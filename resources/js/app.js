import Alpine from 'alpinejs';
import tippy, { createSingleton } from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import flatpickr from 'flatpickr';
import { Portuguese } from 'flatpickr/dist/l10n/pt.js';
import { Spanish } from 'flatpickr/dist/l10n/es.js';

Alpine.data('toaster', (initial = null, duration = 6000) => ({
    open: false,
    type: 'success',
    message: '',
    timer: null,

    init() {
        window.addEventListener('toast', (event) => this.show(event.detail))

        if (initial) {
            this.$nextTick(() => this.show(initial))
        }
    },

    show({ type = 'success', message = '' }) {
        this.type = type
        this.message = message
        this.open = true

        clearTimeout(this.timer)
        this.timer = setTimeout(() => this.dismiss(), duration)
    },

    dismiss() {
        clearTimeout(this.timer)
        this.open = false
    },
}))

Alpine.data('backToTop', () => ({
    visible: false,

    init() {
        const update = () => (this.visible = window.scrollY > window.innerHeight * 0.6)

        update()
        window.addEventListener('scroll', update, { passive: true })
    },

    scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' })
    },
}))

function onReady(callback) {
    document.readyState === 'loading'
        ? document.addEventListener('DOMContentLoaded', callback)
        : callback()
}

let tooltips = []
let tooltipSingleton = null

function initTooltips() {
    const fresh = document.querySelectorAll('[data-tooltip]:not([data-tooltip-ready])')

    fresh.forEach((target) => target.setAttribute('data-tooltip-ready', ''))

    const stale = tooltips.filter((instance) => ! instance.reference.isConnected)

    tooltips = tooltips
        .filter((instance) => instance.reference.isConnected)
        .concat(fresh.length ? tippy(fresh, {
            content: (target) => target.dataset.tooltip,
            trigger: 'mouseenter',
        }) : [])

    if (! tooltips.length) {
        return
    }

    if (tooltipSingleton) {
        tooltipSingleton.setInstances(tooltips)
    } else {
        tooltipSingleton = createSingleton(tooltips, {
            theme: 'andarilha',
            placement: 'top',
            offset: [0, 14],
            trigger: 'mouseenter',
            delay: [60, 140],
            moveTransition: 'transform 0.35s cubic-bezier(0.22, 1, 0.36, 1)',
        })
    }

    stale.forEach((instance) => instance.destroy())
}

function initDotGrid() {
    const grid = document.querySelector('[data-dot-grid]')

    if (! grid) {
        return
    }

    let frame = null
    let x = 0
    let y = 0

    const paint = () => {
        frame = null
        grid.style.setProperty('--cursor-x', `${x}px`)
        grid.style.setProperty('--cursor-y', `${y}px`)
    }

    window.addEventListener('pointermove', (event) => {
        if (event.pointerType === 'touch') {
            return
        }

        x = event.clientX
        y = event.clientY
        grid.classList.add('is-lit')

        if (frame === null) {
            frame = requestAnimationFrame(paint)
        }
    }, { passive: true })

    document.addEventListener('mouseleave', () => grid.classList.remove('is-lit'))
}

function initDatePickers() {
    const inputs = document.querySelectorAll('[data-flatpickr]')

    if (! inputs.length) {
        return
    }

    const locales = { pt: Portuguese, es: Spanish }
    const language = document.documentElement.lang.slice(0, 2)

    inputs.forEach((input) => {
        const picker = flatpickr(input, {
            locale: locales[language] ?? 'default',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: input.dataset.flatpickr || 'd/m/Y',
            minDate: input.getAttribute('min'),
            disableMobile: true,
            monthSelectorType: 'static',
        })

        input.form?.addEventListener('quote-reset', () => picker.clear())
    })
}

function initReveal() {
    const targets = document.querySelectorAll('[data-reveal]')

    if (! targets.length) {
        return
    }

    if (! ('IntersectionObserver' in window)) {
        targets.forEach((target) => target.classList.add('is-revealed'))

        return
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (! entry.isIntersecting) {
                return
            }

            entry.target.style.transitionDelay = `${entry.target.dataset.reveal || 0}ms`
            entry.target.classList.add('is-revealed')
            observer.unobserve(entry.target)
        })
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' })

    targets.forEach((target) => observer.observe(target))
}

window.Alpine = Alpine;
window.tippy = tippy;

Alpine.start();

onReady(() => {
    initTooltips()
    initDatePickers()
    initDotGrid()
    initReveal()

    window.addEventListener('table-updated', () => initTooltips())
});
