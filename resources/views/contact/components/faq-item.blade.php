@props(['question', 'index'])

<div class="border-b border-white/10">
    <h3>
        <button type="button"
                @click="open = open === {{ $index }} ? null : {{ $index }}"
                :aria-expanded="open === {{ $index }}"
                aria-controls="faq-{{ $question }}"
                class="flex w-full items-center justify-between gap-6 py-5 text-left text-sm text-white transition-colors hover:text-ember-400">
            {{ __('pages.contact.faq.'.$question.'.question') }}
            <svg class="size-4 shrink-0 text-white/40 transition-transform duration-300"
                 :class="open === {{ $index }} ? 'rotate-45 text-ember-500' : ''"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
        </button>
    </h3>

    <div id="faq-{{ $question }}"
         class="grid transition-all duration-500 ease-in-out"
         :class="open === {{ $index }} ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
        <div class="overflow-hidden">
            <p class="max-w-2xl pb-5 text-[12px] leading-[1.9] text-white/55">
                {{ __('pages.contact.faq.'.$question.'.answer') }}
            </p>
        </div>
    </div>
</div>
