@props(['stat'])

<div>
    <p class="font-display text-[clamp(2.25rem,4vw,3.25rem)] font-black leading-none text-ember-500">
        {{ $stat->value }}
    </p>
    <p class="mt-3 text-[11px] leading-relaxed text-white/50">{{ $stat->label() }}</p>
</div>
