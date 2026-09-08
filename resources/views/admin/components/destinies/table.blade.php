@props(['destinies'])

<div x-data class="overflow-hidden rounded-2xl border border-white/10 bg-night-900">
    @if ($destinies->isEmpty())
        <x-admin::empty-state :title="__('admin.destinies.empty.title')" :description="__('admin.destinies.empty.description')" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] border-collapse text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        @foreach (['name', 'country', 'postal_code', 'quotations', 'status'] as $column)
                            <th scope="col" class="label-xs px-5 py-4 text-white/40">
                                {{ __('admin.destinies.columns.'.$column) }}
                            </th>
                        @endforeach
                        <th scope="col" class="label-xs px-5 py-4 text-right text-white/40">
                            {{ __('admin.quotations.columns.actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($destinies as $destiny)
                        <x-admin::destinies.row :destiny="$destiny" />
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@if ($destinies->hasPages())
    <div class="mt-6">
        {{ $destinies->links('admin.components.pagination') }}
    </div>
@endif
