@props(['config'])

<div x-data="quotationAnswer({{ Js::from($config) }})" x-on:open-modal.window="capture($event.detail)">
    <x-admin::modal name="quotation-answer" :title="__('admin.quotations.answer.title')">
        <p class="mb-6 text-[12px] leading-relaxed text-white/50">
            {{ __('admin.quotations.answer.context') }}
            <span class="text-white/80" x-text="traveller"></span><span x-show="destiny">, <span class="text-white/80" x-text="destiny"></span></span>
        </p>

        <form method="POST" :action="action" class="space-y-5">
            @csrf
            @method('PATCH')

            <div class="space-y-3">
                <template x-for="option in options" :key="option.value">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-4 transition-colors"
                           :class="answer === option.value ? 'border-ember-500 bg-ember-500/10' : 'border-white/10 hover:border-white/25'">
                        <input type="radio" name="answer" :value="option.value" x-model="answer"
                               class="mt-0.5 size-4 shrink-0 accent-ember-500">
                        <span>
                            <span class="block text-[13px] text-white" x-text="option.label"></span>
                            <span class="mt-1 block text-[11px] leading-relaxed text-white/45" x-text="option.hint"></span>
                        </span>
                    </label>
                </template>
            </div>

            <div x-cloak x-show="answer === 'priced'" x-transition>
                <x-form.money
                    name="price"
                    :label="__('admin.quotations.answer.price')"
                    :placeholder="__('admin.quotations.answer.price_placeholder')"
                    prefix="R$" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" :disabled="! answer"
                        class="label-xs flex-1 rounded-lg bg-ember-500 py-3.5 text-white transition-colors hover:bg-ember-600 disabled:cursor-not-allowed disabled:opacity-40">
                    {{ __('admin.quotations.answer.submit') }}
                </button>

                <button type="button" @click="$dispatch('close-modal')"
                        class="label-xs rounded-lg border border-white/15 px-5 py-3.5 text-white/60 transition-colors hover:border-white/40 hover:text-white">
                    {{ __('admin.cancel') }}
                </button>
            </div>
        </form>
    </x-admin::modal>
</div>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('quotationAnswer', (config) => ({
            quotation: null,
            traveller: '',
            destiny: '',
            answer: '',

            get options() {
                return config.options
            },

            get action() {
                return this.quotation ? config.endpoint.replace(config.placeholder, this.quotation) : ''
            },

            capture(detail) {
                if (! detail || detail.modal !== 'quotation-answer') {
                    return
                }

                this.quotation = detail.quotation
                this.traveller = detail.traveller ?? ''
                this.destiny = detail.destiny ?? ''
                this.answer = ''
            },
        }))
    })
</script>
@endPushOnce
