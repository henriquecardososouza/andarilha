<section id="destinos"
         x-data="destinationShowcase({{ $slides->count() }})"
         class="relative py-20 lg:py-28">
    <div class="mx-auto max-w-[1180px] px-6">

        <x-section-heading :eyebrow="__('landing.showcase.eyebrow')" data-reveal>
            {{ __('landing.showcase.heading') }}
        </x-section-heading>

        <div class="showcase-viewport mt-14 lg:mt-20" data-reveal="120">
            <div x-ref="track"
                 class="flex transition-transform duration-700 ease-in-out"
                 :style="'transform: translateX(-' + offset + 'px)'">
                @foreach ($slides as $slide)
                    <div class="w-full shrink-0 pr-0 lg:w-[86%] lg:pr-16"
                         :aria-hidden="active !== {{ $slide['index'] }}"
                         :inert="active !== {{ $slide['index'] }}">
                        <x-landing::destination-panel :destination="$slide['destination']" />
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-14 flex items-center justify-end gap-3" data-reveal="200">
            <button type="button" @click="previous()"
                    aria-label="{{ __('landing.actions.previous') }}"
                    data-tooltip="{{ __('landing.actions.previous') }}"
                    class="grid size-11 place-items-center rounded-full border border-white/20 text-white transition-colors duration-300 hover:border-ember-500 hover:bg-ember-500">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 12H5m5 5-5-5 5-5"/>
                </svg>
            </button>
            <button type="button" @click="next()"
                    aria-label="{{ __('landing.actions.next') }}"
                    data-tooltip="{{ __('landing.actions.next') }}"
                    class="grid size-11 place-items-center rounded-full border border-white/20 text-white transition-colors duration-300 hover:border-ember-500 hover:bg-ember-500">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 12h15m-5-5 5 5-5 5"/>
                </svg>
            </button>
        </div>

        <div class="mt-8 h-px w-full bg-white/15" data-reveal="240">
            <div class="h-px bg-ember-500 transition-all duration-700 ease-out"
                 :style="'width: ' + progress + '%'"></div>
        </div>
    </div>
</section>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('destinationShowcase', (count) => ({
            active: 0,
            count,
            step: 0,

            init() {
                this.$nextTick(() => this.measure())
                window.addEventListener('resize', () => this.measure())
            },

            measure() {
                const panel = this.$refs.track?.firstElementChild

                this.step = panel ? panel.getBoundingClientRect().width : 0
            },

            get offset() {
                return this.active * this.step
            },

            get progress() {
                return ((this.active + 1) / this.count) * 100
            },

            go(index) {
                this.active = index
            },

            next() {
                this.active = (this.active + 1) % this.count
            },

            previous() {
                this.active = (this.active - 1 + this.count) % this.count
            },
        }))
    })
</script>
@endPushOnce
