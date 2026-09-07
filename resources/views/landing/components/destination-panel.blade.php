@props(['destination'])

<div class="grid items-center gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.05fr)] lg:gap-16">
    <div>
        <h3 class="font-display text-[clamp(2.5rem,6vw,4.5rem)] font-black uppercase leading-[0.9] tracking-[-0.03em] text-ember-500">
            {{ $destination->name() }}
        </h3>
        <p class="label-xs mt-3 text-white/50">{{ $destination->country() }}</p>

        <p class="mt-6 max-w-md text-sm leading-relaxed text-white/60">
            {{ $destination->description() }}
        </p>

        @if ($destination->reviews()->isNotEmpty())
            <p class="label-xs mt-10 text-white/35">{{ __('landing.showcase.reviews_heading') }}</p>

            <div class="mt-5 grid gap-6 sm:grid-cols-2">
                @foreach ($destination->reviews() as $review)
                    <x-landing::review :review="$review" />
                @endforeach
            </div>
        @endif
    </div>

    <div class="relative pb-16 pr-6 sm:pb-20 sm:pr-16 lg:pb-24 lg:pr-24">
        <div class="relative aspect-4/3 overflow-hidden">
            <img src="{{ $destination->image() }}"
                 alt="{{ $destination->name() }}, {{ $destination->country() }}"
                 loading="lazy"
                 class="h-full w-full object-cover object-center">
            <div class="pointer-events-none absolute inset-3 border border-white/20"></div>
        </div>

        <div class="absolute bottom-0 right-0 w-[58%] overflow-hidden shadow-2xl shadow-night-950/60 sm:w-1/2">
            <div class="aspect-4/3">
                <img src="{{ $destination->secondImage() }}"
                     alt="" aria-hidden="true" loading="lazy"
                     @class([
                         'h-full w-full object-cover',
                         'object-center' => $destination->hasSecondPhoto(),
                         'object-[78%_28%] scale-125' => ! $destination->hasSecondPhoto(),
                     ])>
            </div>
            <div class="pointer-events-none absolute inset-0 border border-white/25"></div>
        </div>
    </div>
</div>
