@props(['quotations'])

<div x-data class="overflow-hidden rounded-2xl border border-white/10 bg-night-900">
    @if ($quotations->isEmpty())
        <x-admin::empty-state
            :title="__('admin.quotations.empty.title')"
            :description="__('admin.quotations.empty.description')" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px] border-collapse text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        @foreach (['traveller', 'destiny', 'trip_date', 'status', 'price'] as $column)
                            <th scope="col" class="label-xs px-5 py-4 text-white/40">
                                {{ __('admin.quotations.columns.'.$column) }}
                            </th>
                        @endforeach
                        <th scope="col" class="label-xs px-5 py-4 text-right text-white/40">
                            {{ __('admin.quotations.columns.actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($quotations as $quotation)
                        <x-admin::quotations.row :quotation="$quotation" />
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@if ($quotations->hasPages())
    <div class="mt-6">
        {{ $quotations->links('admin.components.pagination') }}
    </div>
@endif
