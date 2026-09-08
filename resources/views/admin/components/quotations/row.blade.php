@props(['quotation'])

<tr class="border-b border-white/5 transition-colors last:border-0 hover:bg-white/[0.02]">
    <td class="px-5 py-4">
        <p class="text-[13px] text-white">{{ $quotation->user_name }}</p>
        <p class="mt-0.5 text-[11px] text-white/40">{{ $quotation->user_email }}</p>
    </td>

    <td class="px-5 py-4">
        <p class="text-[13px] text-white/80">{{ $quotation->destiny?->name }}</p>
        <p class="mt-0.5 text-[11px] text-white/40">{{ $quotation->destiny?->country }}</p>
    </td>

    <td class="whitespace-nowrap px-5 py-4 text-[13px] text-white/70">
        {{ $quotation->formattedTripDate() }}
    </td>

    <td class="px-5 py-4">
        <x-admin::status-badge :status="$quotation->status" />
    </td>

    <td class="whitespace-nowrap px-5 py-4 text-[13px] text-white/70">
        {{ $quotation->formattedPrice() ?? __('admin.quotations.no_price') }}
    </td>

    <td class="px-5 py-4 text-right">
        @if ($quotation->status->isAnswerable())
            <button type="button"
                    @click="$dispatch('open-modal', {
                        modal: 'quotation-answer',
                        quotation: @js($quotation->uuid),
                        traveller: @js($quotation->user_name),
                        destiny: @js($quotation->destiny?->name),
                    })"
                    class="label-xs inline-flex items-center gap-2 rounded-lg border border-white/15 px-4 py-2.5 text-white/75 transition-colors hover:border-ember-500 hover:bg-ember-500 hover:text-white">
                <x-icons.reply class="size-3.5" />
                {{ __('admin.quotations.answer.open') }}
            </button>
        @else
            <span class="text-[11px] text-white/25">{{ __('admin.quotations.answer.done') }}</span>
        @endif
    </td>
</tr>
