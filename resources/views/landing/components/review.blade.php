@props(['review'])

<figure class="border-l border-white/10 pl-5">
    <div class="flex items-center gap-1"
         title="{{ __('landing.showcase.rating', ['rating' => $review->rating, 'max' => \App\Data\Review::MAX_RATING]) }}">
        @foreach ($review->stars() as $earned)
            <x-icons.star @class(['size-4', 'text-white' => $earned, 'text-white/20' => ! $earned]) />
        @endforeach
    </div>

    <blockquote class="mt-3 text-[12px] leading-relaxed text-white/60">
        {{ $review->text() }}
    </blockquote>

    <figcaption class="mt-4 flex items-center gap-3">
        @if ($review->photoUrl())
            <img src="{{ $review->photoUrl() }}" alt="" aria-hidden="true"
                 class="size-8 shrink-0 rounded-full object-cover">
        @else
            <span aria-hidden="true"
                  class="grid size-8 shrink-0 place-items-center rounded-full bg-ember-500/15 text-[10px] font-semibold tracking-wide text-ember-400">
                {{ $review->initials() }}
            </span>
        @endif
        <span class="text-[11px] text-white/70">{{ $review->author }}</span>
    </figcaption>
</figure>
