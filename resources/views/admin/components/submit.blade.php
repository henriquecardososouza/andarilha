<button type="submit"
        class="label-xs group mt-8 flex w-full items-center justify-center gap-3 rounded-lg bg-ember-500 py-4 text-white transition-colors duration-300 hover:bg-ember-600">
    {{ $slot }}
    <svg class="size-3.5 transition-transform duration-300 group-hover:translate-x-1"
         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 12h15m-5-5 5 5-5 5"/>
    </svg>
</button>
