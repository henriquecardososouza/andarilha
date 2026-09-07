@props(['member'])

<article class="rounded-2xl border border-white/10 bg-white/[0.02] p-7">
    <div class="flex items-center gap-4">
        @if ($member->photoUrl())
            <img src="{{ $member->photoUrl() }}" alt="" aria-hidden="true"
                 class="size-12 shrink-0 rounded-full object-cover">
        @else
            <span aria-hidden="true"
                  class="grid size-12 shrink-0 place-items-center rounded-full bg-ember-500/15 text-[13px] font-semibold tracking-wide text-ember-400">
                {{ $member->initials() }}
            </span>
        @endif
        <div>
            <p class="text-sm text-white">{{ $member->name }}</p>
            <p class="label-xs mt-1 text-white/40">{{ $member->role() }}</p>
        </div>
    </div>
    <p class="mt-5 text-[12px] leading-relaxed text-white/55">{{ $member->bio() }}</p>
</article>
