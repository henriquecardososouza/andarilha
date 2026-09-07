@props(['index'])

<div x-show="active === {{ $index }}"
     x-transition:enter="transition-transform duration-700 ease-in-out"
     x-transition:enter-start="translate-y-full"
     x-transition:enter-end="translate-y-0"
     x-transition:leave="transition-transform duration-700 ease-in-out"
     x-transition:leave-start="translate-y-0"
     x-transition:leave-end="-translate-y-full"
     {{ $attributes }}
     @if ($index > 0) style="display: none" @endif>
    {{ $slot }}
</div>
