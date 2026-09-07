<section id="contato" class="relative isolate overflow-hidden bg-night-950">
    <img src="{{ $backdrop?->image() }}" alt="" aria-hidden="true" loading="lazy"
         class="absolute inset-0 -z-20 h-full w-full object-cover object-center opacity-30 saturate-50">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(115%_85%_at_72%_16%,rgba(128,80,200,0.5),transparent_62%)]"></div>
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(75%_65%_at_15%_88%,rgba(46,62,116,0.55),transparent_72%)]"></div>
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(180deg,#1f2532_0%,rgba(23,22,48,0.55)_38%,rgba(15,17,28,0.9)_100%)]"></div>

    <div class="relative mx-auto max-w-[1180px] px-6 py-24 lg:py-32">
        <div class="grid items-center gap-14 lg:grid-cols-[minmax(0,1fr)_minmax(0,27rem)] lg:gap-20">
            <div class="relative" data-reveal>
                <h2 class="max-w-xl font-display text-[clamp(2.25rem,5.5vw,3.75rem)] font-bold uppercase leading-[1.02] tracking-tight text-white">
                    {{ __('landing.contact.heading') }}
                </h2>

                <span class="pointer-events-none absolute bottom-3 left-[25rem] hidden h-44 w-px origin-bottom -rotate-[33deg] bg-gradient-to-t from-white/60 via-white/25 to-transparent xl:block"></span>

                <p class="mt-8 max-w-sm text-[13px] leading-[1.9] text-white/60">
                    {{ __('landing.contact.description') }}
                </p>
            </div>

            <x-quote-form />
        </div>
    </div>
</section>
