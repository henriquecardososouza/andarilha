@props([
    'name',
    'endpoint' => null,
    'options' => null,
    'label' => null,
    'placeholder' => '',
    'id' => null,
    'selected' => null,
    'clearLabel' => null,
])

@php
    $id ??= 'field-'.$name;

    $config = [
        'endpoint' => $endpoint,
        'options' => $options,
        'placeholder' => $placeholder,
        'searchPlaceholder' => __('landing.contact.form.search_placeholder'),
        'searchingLabel' => __('landing.contact.form.searching'),
        'emptyLabel' => __('landing.contact.form.no_results'),
        'clearLabel' => $clearLabel,
        'initial' => $selected,
    ];
@endphp

<x-form.field :name="$name"
              x-data="searchSelect({{ Js::from($config) }})"
              @quote-reset.window="reset()"
              @click.outside="close()"
              @keydown.escape="close()"
              class="relative">

    @if ($label)
        <x-form.label id="{{ $id }}-label">{{ $label }}</x-form.label>
    @endif

    <input type="hidden" name="{{ $name }}" :value="value">

    <button type="button" x-ref="button" @click="toggle()"
            @keydown.down.prevent="move(1)" @keydown.up.prevent="move(-1)"
            @keydown.enter.prevent="pick()"
            role="combobox" aria-haspopup="listbox"
            aria-labelledby="{{ $id }}-label"
            :aria-expanded="open"
            :class="$data.errors?.{{ $name }} ? 'border-red-400/70' : (open ? 'border-ember-500' : 'border-white/15')"
            {{ $attributes->class([
                'flex w-full items-center justify-between gap-3 rounded-lg border border-white/15 bg-white/[0.03] px-4 py-3 text-left text-sm text-white outline-none transition-colors',
            ]) }}>
        <span :class="selectedLabel ? 'text-white' : 'text-white/30'"
              x-text="selectedLabel || placeholder"></span>
        <svg class="size-4 shrink-0 text-white/40 transition-transform duration-200"
             :class="open && 'rotate-180'"
             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="m6 9 6 6 6-6"/>
        </svg>
    </button>

    <div x-cloak x-show="open"
         x-transition:enter="transition duration-200 ease-out"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition duration-150 ease-in"
         x-transition:leave-end="opacity-0"
         class="absolute inset-x-0 top-full z-30 mt-2 rounded-xl border border-white/10 bg-night-900 p-1.5 shadow-2xl shadow-night-950/70">

        <div class="relative mb-1.5">
            <svg class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-white/30"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                <circle cx="11" cy="11" r="7"/>
                <path d="m20 20-3.5-3.5"/>
            </svg>
            <input type="text" x-ref="search" x-model="query" @input="search()"
                   @keydown.down.prevent="move(1)" @keydown.up.prevent="move(-1)"
                   @keydown.enter.prevent="pick()"
                   placeholder="{{ __('landing.contact.form.search_placeholder') }}"
                   class="w-full rounded-lg bg-white/[0.04] py-2.5 pl-9 pr-3 text-sm text-white outline-none placeholder:text-white/30 focus:bg-white/[0.07]">
        </div>

        <div class="max-h-56 overflow-y-auto">
            <template x-if="loading">
                <p class="px-3 py-3 text-[12px] text-white/40" x-text="searchingLabel"></p>
            </template>

            <template x-if="! loading && ! matches.length">
                <p class="px-3 py-3 text-[12px] text-white/40" x-text="emptyLabel"></p>
            </template>

            <template x-for="(option, index) in visible" :key="option.value">
                <button type="button" role="option"
                        @click="choose(option)" @mouseenter="highlighted = index"
                        :aria-selected="option.value === value"
                        :class="[
                            index === highlighted ? 'bg-white/8 text-white' : 'text-white/65',
                            option.value === '' ? 'italic' : '',
                        ]"
                        class="flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition-colors">
                    <span x-text="option.label"></span>
                    <span class="shrink-0 text-[10px] uppercase tracking-[0.14em] text-white/30" x-text="option.note"></span>
                </button>
            </template>
        </div>
    </div>
</x-form.field>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('searchSelect', (config) => ({
            endpoint: config.endpoint,
            placeholder: config.placeholder ?? '',
            searchingLabel: config.searchingLabel ?? '',
            emptyLabel: config.emptyLabel ?? '',
            clearLabel: config.clearLabel ?? null,
            isStatic: Array.isArray(config.options),

            open: false,
            loading: false,
            query: '',
            options: Array.isArray(config.options) ? config.options : [],
            highlighted: 0,

            value: config.initial?.value ?? '',
            selectedLabel: config.initial?.label ?? '',

            debounce: null,
            request: 0,

            get matches() {
                if (! this.isStatic || ! this.query) {
                    return this.options
                }

                const needle = this.query.toLowerCase()

                return this.options.filter((option) => `${option.label} ${option.note ?? ''}`
                    .toLowerCase()
                    .includes(needle))
            },

            get visible() {
                return this.clearLabel
                    ? [{ value: '', label: this.clearLabel, note: '' }, ...this.matches]
                    : this.matches
            },

            toggle() {
                this.open ? this.close() : this.show()
            },

            show() {
                this.open = true
                this.$nextTick(() => this.$refs.search?.focus())

                if (! this.isStatic && ! this.options.length) {
                    this.load()
                }
            },

            close() {
                this.open = false
            },

            search() {
                if (this.isStatic) {
                    this.highlighted = 0

                    return
                }

                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => this.load(), 250)
            },

            async load() {
                const ticket = ++this.request

                this.loading = true

                try {
                    const url = new URL(this.endpoint, window.location.origin)
                    url.searchParams.set('q', this.query)

                    const response = await fetch(url, { headers: { Accept: 'application/json' } })
                    const payload = await response.json()

                    if (ticket !== this.request) {
                        return
                    }

                    this.options = payload.data ?? []
                    this.highlighted = 0
                } catch (error) {
                    if (ticket === this.request) {
                        this.options = []
                    }
                } finally {
                    if (ticket === this.request) {
                        this.loading = false
                    }
                }
            },

            choose(option) {
                this.value = option.value
                this.selectedLabel = option.value === '' ? '' : option.label
                this.close()
                this.$refs.button?.focus()
            },

            move(step) {
                if (! this.open) {
                    return this.show()
                }

                if (this.visible.length) {
                    this.highlighted = (this.highlighted + step + this.visible.length) % this.visible.length
                }
            },

            pick() {
                if (! this.open) {
                    return this.show()
                }

                if (this.visible[this.highlighted]) {
                    this.choose(this.visible[this.highlighted])
                }
            },

            reset() {
                this.value = ''
                this.selectedLabel = ''
                this.query = ''
                this.highlighted = 0

                if (! this.isStatic) {
                    this.options = []
                }

                this.close()
            },
        }))
    })
</script>
@endPushOnce
