@props([
    'name',
    'label' => null,
    'id' => null,
    'placeholder' => '',
    'prefix' => null,
])

@php
    $id ??= 'field-'.$name;
@endphp

<x-form.field :name="$name" x-data="moneyInput({{ Js::from(old($name, '')) }})">
    @if ($label)
        <x-form.label :for="$id">{{ $label }}</x-form.label>
    @endif

    <div class="relative">
        @if ($prefix)
            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-white/40">{{ $prefix }}</span>
        @endif

        <input type="hidden" name="{{ $name }}" :value="raw">

        <input id="{{ $id }}" type="text" inputmode="decimal" autocomplete="off"
               :value="display"
               @input="format($event)"
               @keydown="guard($event)"
               placeholder="{{ $placeholder }}"
               :class="$data.errors?.{{ $name }} && 'border-red-400/70'"
               {{ $attributes->class([
                   'w-full rounded-lg border border-white/15 bg-white/[0.03] py-3 text-sm text-white outline-none transition-colors placeholder:text-white/30 focus:border-ember-500',
                   'pl-11 pr-4' => $prefix,
                   'px-4' => ! $prefix,
               ]) }}>
    </div>
</x-form.field>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('moneyInput', (initial = '') => ({
            cents: initial ? Math.round(Number(initial) * 100) : 0,

            get raw() {
                return this.cents ? (this.cents / 100).toFixed(2) : ''
            },

            get display() {
                if (! this.cents) {
                    return ''
                }

                return new Intl.NumberFormat(document.documentElement.lang, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }).format(this.cents / 100)
            },

            set display(value) {
                const digits = String(value ?? '').replace(/\D/g, '').slice(0, 11)

                this.cents = digits ? Number(digits) : 0
            },

            format(event) {
                this.display = event.target.value
                event.target.value = this.display
            },

            guard(event) {
                if (event.key === 'Backspace' && ! event.target.value) {
                    this.cents = 0
                }
            },
        }))
    })
</script>
@endPushOnce
