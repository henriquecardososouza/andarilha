@props([
    'image' => null,
    'eyebrow' => null,
    'title',
    'lead' => null,
])

<section {{ $attributes->class(['relative isolate overflow-hidden bg-night-950']) }}>
    @if ($image)
        <img src="{{ $image }}" alt="" aria-hidden="true"
             class="absolute inset-0 -z-20 h-full w-full object-cover object-center">
    @endif

    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-night-950/85 via-night-950/45 to-night-800"></div>
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-night-950/85 via-night-950/25 to-transparent"></div>

    <div class="relative mx-auto max-w-[1180px] px-6 pb-20 pt-40 lg:pb-28 lg:pt-48">
        @if ($eyebrow)
            <p class="mb-6 text-[11px] font-medium uppercase tracking-[0.22em] text-white/70" data-reveal>
                {{ $eyebrow }}
            </p>
        @endif

        <h1 class="max-w-3xl font-display text-[clamp(2.5rem,7vw,5.5rem)] font-black uppercase leading-[0.92] tracking-[-0.03em] text-white"
            data-reveal="80">
            {{ $title }}
        </h1>

        @if ($lead)
            <p class="mt-7 max-w-lg text-sm leading-relaxed text-white/60" data-reveal="160">
                {{ $lead }}
            </p>
        @endif
    </div>
</section>
