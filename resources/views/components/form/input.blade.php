@props([
    'name',
    'label' => null,
    'type' => 'text',
    'id' => null,
])

@php
    $id ??= 'field-'.$name;
@endphp

<x-form.field :name="$name">
    @if ($label)
        <x-form.label :for="$id">{{ $label }}</x-form.label>
    @endif

    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
           value="{{ old($name) }}"
           :class="errors?.{{ $name }} ? 'border-red-400/70' : 'border-white/15'"
           {{ $attributes->class([
               'w-full rounded-lg border border-white/15 bg-white/[0.03] px-4 py-3 text-sm text-white outline-none transition-colors placeholder:text-white/30 focus:border-ember-500',
           ]) }}>
</x-form.field>
