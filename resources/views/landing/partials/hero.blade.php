<section id="inicio"
         x-data="heroSlider({{ $slides->count() }})"
         @keydown.window.arrow-right="next(); play()"
         @keydown.window.arrow-left="previous(); play()"
         class="relative isolate min-h-[100svh] overflow-hidden bg-night-950">

    @foreach ($slides as $slide)
        <div x-show="active === {{ $slide['index'] }}"
             x-transition:enter="transition-opacity duration-[1200ms] ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-[1200ms] ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 -z-10 overflow-hidden"
             @if (! $loop->first) style="display: none" @endif>
            <img src="{{ $slide['destination']->image() }}"
                 alt="{{ $slide['destination']->name() }}, {{ $slide['destination']->country() }}"
                 class="h-full w-full object-cover object-center"
                 :class="{ 'animate-kenburns': zooming({{ $slide['index'] }}) }"
                 loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                 fetchpriority="{{ $loop->first ? 'high' : 'low' }}">
        </div>
    @endforeach

    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-night-950/85 via-night-950/30 to-night-950/80"></div>
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-night-950/80 via-night-950/15 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 -z-10 h-72 bg-gradient-to-t from-night-800 via-night-800/70 to-transparent"></div>

    <div class="relative mx-auto flex min-h-[100svh] max-w-[1180px] flex-col px-6 pb-20 pt-32 lg:pb-24 lg:pt-40">

        <div class="flex flex-1 items-center">
            <div class="grid w-full grid-cols-1 items-center gap-14 lg:grid-cols-[minmax(0,1fr)_auto]">

                <div>
                    <p class="mb-7 text-[11px] font-medium uppercase tracking-[0.22em] text-white/70" data-reveal>
                        {{ __('landing.brand.slogan') }}
                    </p>

                    <h1 data-reveal="80" class="font-display text-[clamp(3rem,9.5vw,8rem)] font-black uppercase leading-[0.88] tracking-[-0.035em]">
                        <span class="block text-white">{{ __('landing.hero.verb') }}</span>

                        <span class="-my-[0.12em] grid overflow-hidden leading-[1.12]">
                            @foreach ($slides as $slide)
                                <x-landing::hero-layer :index="$slide['index']" class="col-start-1 row-start-1 block text-ember-500">
                                    {{ $slide['destination']->name() }}
                                </x-landing::hero-layer>
                            @endforeach
                        </span>
                    </h1>

                    <div class="mt-7 grid overflow-hidden" data-reveal="160">
                        @foreach ($slides as $slide)
                            <x-landing::hero-layer :index="$slide['index']" class="col-start-1 row-start-1 max-w-md text-sm leading-relaxed text-white/60">
                                {{ $slide['destination']->description() }}
                            </x-landing::hero-layer>
                        @endforeach
                    </div>
                </div>

                <ol class="hidden shrink-0 flex-col items-end gap-3.5 lg:flex" data-reveal="320">
                    @foreach ($slides as $slide)
                        <li>
                            <button type="button" @click="go({{ $slide['index'] }})"
                                    aria-label="{{ __('landing.actions.view_destination', ['city' => $slide['destination']->name()]) }}"
                                    class="group flex items-center justify-end gap-5">
                                <span class="font-display tabular-nums transition-colors duration-300"
                                      :class="active === {{ $slide['index'] }}
                                        ? 'text-2xl font-bold text-white'
                                        : 'text-xs font-semibold text-white/35 group-hover:text-white/70'">
                                    {{ $slide['number'] }}
                                </span>
                                <span class="h-px bg-white transition-all duration-500"
                                      :class="active === {{ $slide['index'] }} ? 'w-14 opacity-100' : 'w-0 opacity-0'"></span>
                            </button>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <div class="mt-12 grid lg:mt-16" data-reveal="240">
            @foreach ($slides as $slide)
                <div x-show="active === {{ $slide['index'] }}"
                     x-transition:enter="transition duration-700 ease-in-out"
                     x-transition:enter-start="translate-y-full opacity-0"
                     x-transition:enter-end="translate-y-0 opacity-100"
                     x-transition:leave="transition duration-700 ease-in-out"
                     x-transition:leave-start="translate-y-0 opacity-100"
                     x-transition:leave-end="-translate-y-full opacity-0"
                     class="col-start-1 row-start-1 flex items-center gap-9"
                     @if (! $loop->first) style="display: none" @endif>
                    @foreach ($slide['destination']->icons() as $icon)
                        <x-landing::city-icon :icon="$icon" />
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <a href="#destinos"
       class="group absolute inset-x-0 bottom-6 z-20 mx-auto flex w-max flex-col items-center gap-3 lg:bottom-8"
       data-reveal="400">
        <span class="label-xs text-white/50 transition-colors duration-300 group-hover:text-white">
            {{ __('landing.actions.scroll_hint') }}
        </span>
        <span class="relative block h-10 w-px overflow-hidden bg-white/15">
            <span class="animate-scroll-cue absolute inset-x-0 top-0 block h-4 bg-ember-500"></span>
        </span>
    </a>
</section>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('heroSlider', (count, duration = 4500, fade = 1200) => ({
            active: 0,
            count,
            duration,
            timer: null,
            zoom: [0],
            settle: null,

            init() {
                this.play()
                document.addEventListener('visibilitychange', () => {
                    document.hidden ? this.pause() : this.play()
                })
            },

            play() {
                this.pause()
                this.timer = setInterval(() => this.next(), this.duration)
            },

            pause() {
                clearInterval(this.timer)
                this.timer = null
            },

            show(index) {
                if (index === this.active) {
                    return
                }

                this.active = index

                if (! this.zoom.includes(index)) {
                    this.zoom.push(index)
                }

                clearTimeout(this.settle)
                this.settle = setTimeout(() => (this.zoom = [this.active]), fade + 100)
            },

            zooming(index) {
                return this.zoom.includes(index)
            },

            go(index) {
                this.show(index)
                this.play()
            },

            next() {
                this.show((this.active + 1) % this.count)
            },

            previous() {
                this.show((this.active - 1 + this.count) % this.count)
            },
        }))
    })
</script>
@endPushOnce
