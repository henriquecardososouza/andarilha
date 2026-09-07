<section class="relative py-20 lg:py-28">
    <div class="mx-auto max-w-[1180px] px-6">
        <x-section-heading data-reveal>{{ __('pages.about.story.heading') }}</x-section-heading>

        <div class="mt-14 grid items-center gap-12 lg:mt-20 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.05fr)] lg:gap-16">
            <div class="space-y-6 text-sm leading-relaxed text-white/60" data-reveal="120">
                <p>{{ __('pages.about.story.first') }}</p>
                <p>{{ __('pages.about.story.second') }}</p>
            </div>

            <div class="relative pb-16 pr-6 sm:pb-20 sm:pr-16 lg:pb-24 lg:pr-24" data-reveal="200">
                <div class="relative aspect-4/3 overflow-hidden rounded-xl">
                    <img src="{{ $images->first()->image() }}"
                         alt="{{ $images->first()->name() }}" loading="lazy"
                         class="h-full w-full object-cover object-center">
                    <div class="pointer-events-none absolute inset-3 rounded-lg border border-white/20"></div>
                </div>

                <div class="absolute bottom-0 right-0 w-[58%] overflow-hidden rounded-xl shadow-2xl shadow-night-950/60 sm:w-1/2">
                    <div class="aspect-4/3">
                        <img src="{{ $images->last()->image() }}"
                             alt="{{ $images->last()->name() }}" loading="lazy"
                             class="h-full w-full object-cover object-center">
                    </div>
                    <div class="pointer-events-none absolute inset-0 rounded-xl border border-white/25"></div>
                </div>
            </div>
        </div>
    </div>
</section>
