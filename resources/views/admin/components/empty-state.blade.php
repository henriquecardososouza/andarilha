@props(['title', 'description' => null])

<div class="flex flex-col items-center gap-3 px-6 py-20 text-center">
    <x-icons.inbox class="size-8 text-white/20" />
    <p class="text-sm text-white/70">{{ $title }}</p>
    @if ($description)
        <p class="max-w-sm text-[12px] leading-relaxed text-white/40">{{ $description }}</p>
    @endif
</div>
