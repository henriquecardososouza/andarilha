@props(['icon'])

<span role="img"
      aria-label="{{ $icon->label() }}"
      data-tooltip="{{ $icon->label() }}"
      class="block cursor-help text-white/60 transition-colors duration-300 hover:text-ember-400">
    <x-dynamic-component :component="$icon->component()" class="size-8" />
</span>
