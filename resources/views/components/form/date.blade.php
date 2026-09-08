@props([
    'name',
    'label' => null,
    'id' => null,
    'min' => null,
    'value' => null,
    'format' => 'd/m/Y',
])

@php
    $id ??= 'field-'.$name;
@endphp

<x-form.field :name="$name">
    @if ($label)
        <x-form.label :for="$id">{{ $label }}</x-form.label>
    @endif

    <input id="{{ $id }}" name="{{ $name }}" type="text" readonly
           data-flatpickr="{{ $format }}"
           @if ($min) min="{{ $min }}" @endif
           value="{{ old($name, $value) }}"
           :class="$data.errors?.{{ $name }} ? 'border-red-400/70' : 'border-white/15'"
           {{ $attributes->class([
               'w-full cursor-pointer rounded-lg border border-white/15 bg-white/[0.03] px-4 py-3 text-sm text-white outline-none transition-colors placeholder:text-white/30 focus:border-ember-500',
           ]) }}>
</x-form.field>
