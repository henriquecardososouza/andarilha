@props(['status'])

<span class="inline-flex w-max items-center rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.1em] {{ $status->badge() }}">
    {{ $status->label() }}
</span>
