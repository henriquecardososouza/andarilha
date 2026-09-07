<button type="button"
        x-data="backToTop"
        x-cloak
        x-show="visible"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-end="opacity-0 translate-y-3"
        @click="scrollToTop()"
        aria-label="{{ __('landing.actions.back_to_top') }}"
        data-tooltip="{{ __('landing.actions.back_to_top') }}"
        class="fixed bottom-6 right-6 z-40 grid size-12 place-items-center rounded-full border border-white/20 bg-night-950/80 text-white shadow-2xl shadow-night-950/60 backdrop-blur-sm transition-colors duration-300 hover:border-ember-500 hover:text-ember-400 lg:bottom-8 lg:right-8">
    <x-icons.arrow-up class="size-[18px]" />
</button>
