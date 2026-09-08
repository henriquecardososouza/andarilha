@props([
    'endpoint',
    'search' => null,
    'placeholder',
    'filterKeys' => [],
    'filtersModal' => null,
])

<div x-data="tableSearch({{ Js::from($endpoint) }}, {{ Js::from($filterKeys) }})"
     class="flex flex-col gap-3 sm:flex-row sm:items-center">
    <div class="relative flex-1 sm:max-w-sm">
        <x-icons.search class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-white/30" />
        <input type="search" x-model="term" @input="search()"
               placeholder="{{ $placeholder }}"
               class="w-full rounded-lg border border-white/15 bg-night-900 py-3 pl-10 pr-4 text-sm text-white outline-none transition-colors placeholder:text-white/30 focus:border-ember-500">
    </div>

    @if ($filtersModal)
        <button type="button" @click="$dispatch('open-modal', { modal: '{{ $filtersModal }}' })"
                class="label-xs relative flex shrink-0 items-center gap-2.5 rounded-lg border border-white/15 px-5 py-3 text-white/75 transition-colors hover:border-white/40 hover:text-white">
            <x-icons.filter class="size-4" />
            {{ __('admin.quotations.filters.open') }}

            <span x-cloak x-show="activeFilters > 0"
                  x-transition:enter="transition duration-200"
                  x-transition:enter-start="opacity-0 scale-75"
                  class="grid size-5 place-items-center rounded-full bg-ember-500 text-[10px] font-bold text-white"
                  x-text="activeFilters"></span>
        </button>
    @endif

    <div class="sm:ml-auto">{{ $slot }}</div>
</div>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('tableSearch', (endpoint, filterKeys) => ({
            term: new URL(window.location.href).searchParams.get('search') ?? '',
            activeFilters: 0,
            debounce: null,

            init() {
                this.count()
                window.addEventListener('table-updated', () => this.count())
                window.addEventListener('popstate', () => {
                    this.term = new URL(window.location.href).searchParams.get('search') ?? ''
                    this.count()
                })
            },

            count() {
                const params = new URLSearchParams(window.location.search)

                this.term = params.get('search') ?? ''
                this.activeFilters = filterKeys.filter((key) => (params.get(key) ?? '') !== '').length
            },

            search() {
                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => this.apply(), 300)
            },

            apply() {
                const params = new URLSearchParams(window.location.search)

                this.term ? params.set('search', this.term) : params.delete('search')
                params.delete('page')

                const query = params.toString()

                window.dispatchEvent(new CustomEvent('table-reload', {
                    detail: { url: query ? `${endpoint}?${query}` : endpoint },
                }))
            },
        }))
    })
</script>
@endPushOnce
