@php
    $initial = session('toast') ?? ($errors->any()
        ? ['type' => 'error', 'message' => __('landing.contact.feedback.invalid')]
        : null);
@endphp

<div x-data="toaster({{ Js::from($initial) }})" x-cloak x-show="open"
     x-transition:enter="transition duration-300 ease-out"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition duration-200 ease-in"
     x-transition:leave-end="opacity-0 translate-y-4"
     role="status" aria-live="polite"
     class="fixed bottom-6 left-6 z-[70] w-[calc(100vw-3rem)] max-w-sm rounded-xl border border-white/10 bg-night-950/95 p-4 shadow-2xl shadow-night-950/70 backdrop-blur-md lg:bottom-8 lg:left-8">
    <div class="flex items-start gap-3.5">
        <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full"
              :class="type === 'success' ? 'bg-ember-500/20 text-ember-400' : 'bg-red-400/15 text-red-300'">
            <svg x-show="type === 'success'" class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="m5 13 4.5 4.5L19 7"/>
            </svg>
            <svg x-show="type !== 'success'" class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 7v6m0 4v.5"/>
            </svg>
        </span>

        <p class="flex-1 text-[12px] leading-relaxed text-white/80" x-text="message"></p>

        <button type="button" @click="dismiss()" aria-label="{{ __('landing.actions.close_toast') }}"
                class="-mr-1 -mt-1 grid size-7 shrink-0 place-items-center rounded-md text-white/40 transition-colors hover:text-white">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="m6 6 12 12M18 6 6 18"/>
            </svg>
        </button>
    </div>
</div>
