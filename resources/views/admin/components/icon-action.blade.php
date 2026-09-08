@props(['label', 'tone' => 'neutral'])

<button type="button"
        aria-label="{{ $label }}"
        data-tooltip="{{ $label }}"
        {{ $attributes->class([
            'grid size-8 place-items-center rounded-lg border border-white/15 transition-colors disabled:opacity-50',
            'text-white/60 hover:border-ember-500 hover:text-white' => $tone === 'neutral',
            'text-white/50 hover:border-red-400/60 hover:text-red-200' => $tone === 'danger',
        ]) }}>
    {{ $slot }}
</button>
