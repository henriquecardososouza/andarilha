@props(['name'])

<div {{ $attributes }}>
    {{ $slot }}

    <template x-if="errors?.{{ $name }}">
        <p class="mt-2 text-[11px] text-red-300/90" x-text="errors.{{ $name }}[0]"></p>
    </template>
</div>
