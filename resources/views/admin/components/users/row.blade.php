@props(['user', 'currentUser'])

@php
    $isSelf = $currentUser->is($user);
@endphp

<tr class="border-b border-white/5 transition-colors last:border-0 hover:bg-white/[0.02]">
    <td class="px-5 py-4">
        <p class="text-[13px] text-white">{{ $user->name }}</p>
        @if ($isSelf)
            <p class="mt-0.5 text-[11px] text-ember-400">{{ __('admin.users.you') }}</p>
        @endif
    </td>

    <td class="px-5 py-4 text-[13px] text-white/70">{{ $user->email }}</td>

    <td class="px-5 py-4 text-[13px] {{ $user->invitation_pending ? 'text-amber-200/80' : 'text-white/50' }}">
        {{ $user->invitation_pending ? __('admin.users.verified_no') : __('admin.users.verified_yes') }}
    </td>

    <td class="px-5 py-4">
        <span class="inline-flex w-max items-center rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.1em] {{ $user->blocked ? 'border-red-400/30 bg-red-400/10 text-red-200' : 'border-emerald-400/30 bg-emerald-400/10 text-emerald-200' }}">
            {{ $user->blocked ? __('admin.users.blocked_label') : __('admin.users.active_label') }}
        </span>
    </td>

    <td class="px-5 py-4">
        <div class="flex items-center justify-end gap-2">
            @if ($user->invitation_pending)
                <x-admin::icon-action
                    :label="__('admin.users.resend')"
                    x-data="adminAction({{ Js::from(route('admin.users.invitation', $user)) }}, 'POST')"
                    @click="run()"
                    ::disabled="busy">
                    <x-icons.mail class="size-4" />
                </x-admin::icon-action>
            @endif

            @if ($isSelf)
                <span class="text-[11px] text-white/25">{{ __('admin.users.self_locked') }}</span>
            @else
                <button type="button"
                        x-data="adminAction({{ Js::from(route('admin.users.block', $user)) }}, 'PATCH')"
                        @click="run()"
                        :disabled="busy"
                        class="label-xs inline-flex items-center gap-2 rounded-lg border border-white/15 px-4 py-2.5 text-white/75 transition-colors disabled:opacity-50 {{ $user->blocked ? 'hover:border-emerald-400/60 hover:text-emerald-200' : 'hover:border-red-400/60 hover:text-red-200' }}">
                    <x-icons.lock class="size-3.5" />
                    {{ $user->blocked ? __('admin.users.release') : __('admin.users.block') }}
                </button>
            @endif
        </div>
    </td>
</tr>
