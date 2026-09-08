@props(['destiny'])

<tr class="border-b border-white/5 transition-colors last:border-0 hover:bg-white/[0.02]">
    <td class="px-5 py-4 text-[13px] text-white">{{ $destiny->name }}</td>
    <td class="px-5 py-4 text-[13px] text-white/70">{{ $destiny->country }}</td>
    <td class="px-5 py-4 text-[13px] text-white/50">{{ $destiny->postal_code ?: __('admin.destinies.no_postal_code') }}</td>
    <td class="px-5 py-4 text-[13px] text-white/70">{{ $destiny->quotations_count }}</td>

    <td class="px-5 py-4">
        <x-admin::toggle
            :active="$destiny->active"
            :endpoint="route('admin.destinies.activation', $destiny)"
            :on-label="__('admin.destinies.deactivate')"
            :off-label="__('admin.destinies.activate')" />
    </td>

    <td class="px-5 py-4">
        <div class="flex items-center justify-end gap-2">
            <x-admin::icon-action
                :label="__('admin.destinies.edit')"
                @click="$dispatch('open-modal', {{ Js::from($destiny->edit_payload) }})">
                <x-icons.pencil class="size-4" />
            </x-admin::icon-action>

            <x-admin::icon-action
                tone="danger"
                :label="__('admin.destinies.delete')"
                x-data="adminAction({{ Js::from(route('admin.destinies.destroy', $destiny)) }}, 'DELETE', {{ Js::from(__('admin.destinies.confirm_delete', ['name' => $destiny->name])) }})"
                @click="run()"
                ::disabled="busy">
                <x-icons.trash class="size-4" />
            </x-admin::icon-action>
        </div>
    </td>
</tr>
