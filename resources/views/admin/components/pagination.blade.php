@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('admin.pagination.label') }}"
         class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-[11px] text-white/40">
            {{ __('admin.pagination.summary', [
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ]) }}
        </p>

        <div class="flex items-center gap-1.5">
            @if ($paginator->onFirstPage())
                <span class="label-xs cursor-default rounded-lg border border-white/10 px-4 py-2.5 text-white/20">
                    {{ __('admin.pagination.previous') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="label-xs rounded-lg border border-white/15 px-4 py-2.5 text-white/70 transition-colors hover:border-white/40 hover:text-white">
                    {{ __('admin.pagination.previous') }}
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-[12px] text-white/25">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                  class="grid size-10 place-items-center rounded-lg bg-ember-500 text-[12px] font-semibold text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="grid size-10 place-items-center rounded-lg border border-white/10 text-[12px] text-white/60 transition-colors hover:border-white/40 hover:text-white">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="label-xs rounded-lg border border-white/15 px-4 py-2.5 text-white/70 transition-colors hover:border-white/40 hover:text-white">
                    {{ __('admin.pagination.next') }}
                </a>
            @else
                <span class="label-xs cursor-default rounded-lg border border-white/10 px-4 py-2.5 text-white/20">
                    {{ __('admin.pagination.next') }}
                </span>
            @endif
        </div>
    </nav>
@endif
