@props(['name', 'title', 'description' => null])

<div x-data="{ open: false }"
     x-on:open-modal.window="if ($event.detail?.modal === '{{ $name }}') { open = true; $nextTick(() => $refs.panel?.focus()) }"
     x-on:close-modal.window="open = false"
     @keydown.escape.window="open = false"
     x-cloak
     x-show="open"
     class="fixed inset-0 z-[80] grid place-items-center overflow-y-auto bg-night-950/85 p-6 backdrop-blur-sm">
    <div x-show="open"
         x-transition:enter="transition duration-250 ease-out"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition duration-150 ease-in"
         x-transition:leave-end="opacity-0 scale-95"
         @click.outside="if (! $event.target.closest('.flatpickr-calendar')) open = false"
         x-ref="panel" tabindex="-1"
         role="dialog" aria-modal="true"
         class="w-full max-w-lg rounded-2xl border border-white/10 bg-night-900/95 p-7 shadow-2xl shadow-night-950/70 outline-none backdrop-blur-md">
        <div class="mb-6 flex items-start justify-between gap-6">
            <div>
                <h2 class="font-display text-base font-bold uppercase tracking-[0.1em] text-white">{{ $title }}</h2>
                @if ($description)
                    <p class="mt-2 text-[11px] leading-relaxed text-white/45">{{ $description }}</p>
                @endif
            </div>

            <button type="button" @click="open = false" aria-label="{{ __('admin.close') }}"
                    class="-mr-1 -mt-1 grid size-8 shrink-0 place-items-center rounded-md text-white/40 transition-colors hover:text-white">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
