@props(['endpoint'])

<div x-data="asyncTable({{ Js::from($endpoint) }})"
     @table-reload.window="reload($event.detail?.url)"
     class="relative">
    <div x-cloak x-show="loading"
         class="pointer-events-none absolute inset-0 z-10 grid place-items-center rounded-2xl bg-night-950/50">
        <svg class="size-6 animate-spin text-ember-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.5" class="opacity-25"/>
            <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    </div>

    <div x-ref="results" @click="intercept($event)" :class="loading && 'opacity-40'" class="transition-opacity duration-200">
        {{ $slot }}
    </div>
</div>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('asyncTable', (endpoint) => ({
            endpoint,
            loading: false,
            request: 0,

            init() {
                window.addEventListener('popstate', () => this.fetch(window.location.href, false))
            },

            intercept(event) {
                const link = event.target.closest('a[href]')

                if (! link || link.target === '_blank' || ! link.href.startsWith(this.origin)) {
                    return
                }

                event.preventDefault()
                this.fetch(link.href)
            },

            get origin() {
                return window.location.origin
            },

            reload(url) {
                this.fetch(url ?? window.location.href)
            },

            async fetch(url, push = true) {
                const ticket = ++this.request

                this.loading = true

                try {
                    const response = await fetch(url, {
                        headers: { 'X-Partial': 'table', Accept: 'text/html' },
                    })

                    const markup = await response.text()

                    if (ticket !== this.request) {
                        return
                    }

                    this.$refs.results.innerHTML = markup

                    if (push) {
                        window.history.pushState({}, '', url)
                    }

                    window.dispatchEvent(new CustomEvent('table-updated'))
                } catch (error) {
                    window.location.href = url
                } finally {
                    if (ticket === this.request) {
                        this.loading = false
                    }
                }
            },
        }))

        window.Alpine.data('tableFilters', (endpoint) => ({
            endpoint,

            submit(form) {
                const params = new URLSearchParams(new FormData(form))

                for (const [key, value] of [...params.entries()]) {
                    if (value === '') {
                        params.delete(key)
                    }
                }

                const query = params.toString()

                window.dispatchEvent(new CustomEvent('table-reload', {
                    detail: { url: query ? `${this.endpoint}?${query}` : this.endpoint },
                }))

                window.dispatchEvent(new CustomEvent('close-modal'))
            },

            clear(form) {
                form.dispatchEvent(new CustomEvent('quote-reset', { bubbles: true }))

                window.dispatchEvent(new CustomEvent('table-reload', { detail: { url: this.endpoint } }))
                window.dispatchEvent(new CustomEvent('close-modal'))
            },
        }))
    })
</script>
@endPushOnce

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('adminAction', (url, method, confirmation = null) => ({
            busy: false,
            token: Math.random().toString(36).slice(2),

            listener: null,

            init() {
                this.listener = (event) => {
                    if (event.detail?.token === this.token) {
                        this.send()
                    }
                }

                window.addEventListener('confirm-accepted', this.listener)
            },

            destroy() {
                window.removeEventListener('confirm-accepted', this.listener)
            },

            run() {
                if (this.busy) {
                    return
                }

                if (! confirmation) {
                    return this.send()
                }

                window.dispatchEvent(new CustomEvent('confirm-action', {
                    detail: { message: confirmation, token: this.token },
                }))
            },

            async send() {
                this.busy = true

                const body = new FormData()
                body.append('_method', method)
                body.append('_token', document.querySelector('meta[name="csrf-token"]').content)

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body,
                    })

                    const payload = await response.json().catch(() => ({}))

                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { type: response.ok ? 'success' : 'error', message: payload.message },
                    }))

                    if (response.ok) {
                        window.dispatchEvent(new CustomEvent('table-reload'))
                    }
                } catch (error) {
                    window.location.reload()
                } finally {
                    this.busy = false
                }
            },
        }))
    })
</script>
@endPushOnce
