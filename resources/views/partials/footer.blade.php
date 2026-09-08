<footer class="relative bg-night-900">
    <div class="mx-auto max-w-[1180px] px-6 py-14">
        <div class="flex flex-col gap-10 border-b border-white/10 pb-10 md:flex-row md:items-start md:justify-between" data-reveal>
            <div>
                <a href="{{ route('landing') }}" class="inline-block">
                    <img src="{{ asset('assets/logo.png') }}"
                         alt="{{ __('landing.brand.name') }}: {{ __('landing.brand.slogan') }}"
                         class="h-20 w-auto">
                </a>
                <p class="mt-5 max-w-xs text-[11px] leading-[1.9] text-white/45">
                    {{ __('landing.footer.blurb') }}
                </p>
            </div>

            <nav class="flex flex-col gap-4">
                <p class="label-xs text-white">{{ __('landing.footer.browse') }}</p>
                @foreach ($navigation as $item)
                    <a href="{{ $item['url'] }}" class="text-[12px] text-white/55 transition-colors hover:text-white">
                        {{ __('landing.nav.'.$item['key']) }}
                    </a>
                @endforeach
                @if ($authenticated)
                    <a href="{{ route('admin.quotations.index') }}" class="text-[12px] text-white/55 transition-colors hover:text-white">
                        {{ __('admin.nav.quotations') }}
                    </a>
                @else
                    <a href="{{ route('admin.login') }}" class="text-[12px] text-white/55 transition-colors hover:text-white">
                        {{ __('landing.nav.restricted') }}
                    </a>
                @endif
            </nav>

            <div>
                <p class="label-xs mb-4 text-white">{{ __('landing.footer.contact_heading') }}</p>
                <ul class="space-y-2.5 text-[12px] leading-relaxed text-white/50">
                    @foreach ($channels as $channel)
                        <li class="flex items-start gap-2.5">
                            <x-dynamic-component :component="$channel->component()" class="mt-0.5 size-3.5 shrink-0 text-white/30" />
                            <span>
                                @if ($channel->href)
                                    <a href="{{ $channel->href }}" class="transition-colors hover:text-white">{{ $channel->summary() }}</a>
                                @else
                                    {{ $channel->summary() }}
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <p class="pt-6 text-[11px] text-white/35" data-reveal="120">
            &copy; {{ $year }} {{ __('landing.brand.name') }}. {{ __('landing.footer.rights') }}
        </p>
    </div>
</footer>
