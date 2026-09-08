@props(['title', 'description' => null])

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="font-display text-2xl font-bold uppercase tracking-[0.08em] text-white lg:text-3xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-[12px] text-white/45">{{ $description }}</p>
        @endif
    </div>

    {{ $slot }}
</div>
