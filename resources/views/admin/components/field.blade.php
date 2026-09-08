@props([
    'name',
    'label',
    'type' => 'text',
    'id' => null,
])

@php
    $id ??= 'admin-'.$name;
    $revealable = $type === 'password';
@endphp

<div>
    <x-form.label :for="$id">{{ $label }}</x-form.label>

    <div @if ($revealable) x-data="{ shown: false }" @endif class="relative">
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
               @if ($revealable) :type="shown ? 'text' : 'password'" @endif
               value="{{ $revealable ? '' : old($name, $attributes->get('value')) }}"
               :class="$data.errors?.{{ $name }} && 'border-red-400/70'"
               {{ $attributes->except('value')->class([
                   'w-full rounded-lg border bg-white/[0.03] px-4 py-3 text-sm text-white outline-none transition-colors placeholder:text-white/30 focus:border-ember-500',
                   'pr-12' => $revealable,
                   'border-white/15' => ! $errors->has($name),
                   'border-red-400/70' => $errors->has($name),
               ]) }}>

        @if ($revealable)
            <button type="button" @click="shown = ! shown"
                    :aria-label="shown
                        ? {{ Js::from(__('admin.hide_password')) }}
                        : {{ Js::from(__('admin.show_password')) }}"
                    :aria-pressed="shown"
                    class="absolute right-3 top-1/2 grid size-8 -translate-y-1/2 place-items-center rounded-md text-white/35 transition-colors hover:text-white">
                <x-icons.eye x-show="! shown" class="size-[18px]" />
                <x-icons.eye-off x-cloak x-show="shown" class="size-[18px]" />
            </button>
        @endif
    </div>

    @error($name)
        <p class="mt-2 text-[11px] text-red-300/90">{{ $message }}</p>
    @enderror

    <template x-if="$data.errors?.{{ $name }}">
        <p class="mt-2 text-[11px] text-red-300/90" x-text="$data.errors.{{ $name }}[0]"></p>
    </template>
</div>
