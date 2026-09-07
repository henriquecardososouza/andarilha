<section class="relative pb-24 lg:pb-32">
    <div class="mx-auto max-w-[1180px] px-6">
        <div class="flex flex-col items-start gap-6 rounded-2xl border border-white/10 bg-white/[0.02] p-8 sm:flex-row sm:items-center sm:justify-between lg:p-10"
             data-reveal>
            <p class="max-w-md font-display text-xl font-bold uppercase leading-tight tracking-[0.04em] text-white lg:text-2xl">
                {{ __('pages.about.cta.text') }}
            </p>
            <a href="{{ route('contact') }}"
               class="label-xs group flex shrink-0 items-center gap-3 rounded-lg bg-ember-500 px-7 py-4 text-white transition-colors duration-300 hover:bg-ember-600">
                {{ __('pages.about.cta.action') }}
                <svg class="size-3.5 transition-transform duration-300 group-hover:translate-x-1"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 12h15m-5-5 5 5-5 5"/>
                </svg>
            </a>
        </div>
    </div>
</section>
