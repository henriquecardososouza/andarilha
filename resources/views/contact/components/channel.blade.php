@props(['channel'])

<article class="rounded-2xl border border-white/10 bg-white/[0.02] p-7">
    <x-dynamic-component :component="$channel->component()" class="size-6 text-ember-500" />
    <h3 class="label-xs mt-5 text-white/40">{{ $channel->heading() }}</h3>

    <div class="mt-2 space-y-1 text-sm text-white/80">
        @if ($channel->href)
            <a href="{{ $channel->href }}" class="transition-colors hover:text-ember-400">
                {{ $channel->lines[0] }}
            </a>
        @else
            @foreach ($channel->lines as $line)
                <p>{{ $line }}</p>
            @endforeach
        @endif
    </div>
</article>
