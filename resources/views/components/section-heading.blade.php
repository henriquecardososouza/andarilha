@props([
    'align' => 'left',
    'eyebrow' => null,
])

@php
    $centred = $align === 'center';
@endphp

<div {{ $attributes->class(['w-full']) }}>
    @if ($eyebrow)
        <p @class([
            'mb-4 text-[11px] tracking-[0.08em] text-white/45',
            'text-center' => $centred,
        ])>{{ $eyebrow }}</p>
    @endif

    <div class="flex items-center gap-6 lg:gap-8">
        @if ($centred)
            <span class="h-px flex-1 bg-white/20"></span>
        @endif

        <h2 class="font-display text-[clamp(1.6rem,3.6vw,2.75rem)] font-bold uppercase leading-none tracking-[0.06em] text-white/45">
            {{ $slot }}
        </h2>

        <span class="h-px flex-1 bg-white/20"></span>
    </div>
</div>
