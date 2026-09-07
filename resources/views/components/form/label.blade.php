@props(['for' => null])

@if ($for)
    <label for="{{ $for }}" {{ $attributes->class(['label-xs mb-2.5 block text-white/50']) }}>
        {{ $slot }}
    </label>
@else
    <span {{ $attributes->class(['label-xs mb-2.5 block text-white/50']) }}>
        {{ $slot }}
    </span>
@endif
