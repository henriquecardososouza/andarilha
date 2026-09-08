@props(['users', 'currentUser'])

<div x-data class="overflow-hidden rounded-2xl border border-white/10 bg-night-900">
    @if ($users->isEmpty())
        <x-admin::empty-state :title="__('admin.users.empty.title')" :description="__('admin.users.empty.description')" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] border-collapse text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        @foreach (['name', 'email', 'verified', 'status'] as $column)
                            <th scope="col" class="label-xs px-5 py-4 text-white/40">
                                {{ __('admin.users.columns.'.$column) }}
                            </th>
                        @endforeach
                        <th scope="col" class="label-xs px-5 py-4 text-right text-white/40">
                            {{ __('admin.quotations.columns.actions') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <x-admin::users.row :user="$user" :currentUser="$currentUser" />
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@if ($users->hasPages())
    <div class="mt-6">
        {{ $users->links('admin.components.pagination') }}
    </div>
@endif
