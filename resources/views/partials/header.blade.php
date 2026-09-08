<header x-data="{ menu: false }" class="absolute inset-x-0 top-0 z-50">
    <div class="mx-auto max-w-[1180px] px-6">
        <div class="relative flex items-center justify-between border-b border-white/15 py-4 lg:py-5" data-reveal>
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/icon.png') }}" alt="" aria-hidden="true" class="size-9 shrink-0">
                <span class="font-display text-sm font-extrabold uppercase tracking-[0.14em] text-ember-500">
                    {{ __('landing.brand.name') }}
                </span>
            </a>

            <nav class="hidden lg:flex lg:items-center lg:gap-8">
                @foreach ($navigation as $item)
                    <a href="{{ $item['url'] }}"
                       @if ($item['active']) aria-current="page" @endif
                       class="label-xs relative py-4 transition-colors lg:py-5 {{ $item['active'] ? 'text-white' : 'text-white/60 hover:text-white' }}">
                        {{ __('landing.nav.'.$item['key']) }}
                        @if ($item['active'])
                            <span class="absolute inset-x-0 -bottom-px h-0.5 bg-ember-500"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false" class="relative">
                    <button type="button" @click="open = !open" :aria-expanded="open" aria-haspopup="true"
                            aria-label="{{ __('landing.actions.language') }}"
                            class="label-xs flex items-center gap-2 px-2 py-2 text-white/70 transition-colors hover:text-white">
                        <svg class="size-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M3 12h18M12 3c2.5 2.6 2.5 15.4 0 18-2.5-2.6-2.5-15.4 0-18Z"/>
                        </svg>
                        <span>{{ $locales[$currentLocale]['short'] ?? strtoupper($currentLocale) }}</span>
                        <svg class="size-3 transition-transform duration-200" :class="open && 'rotate-180'"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    <div x-cloak x-show="open"
                         x-transition:enter="transition duration-200 ease-out"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition duration-150 ease-in"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute right-0 top-full z-50 mt-3 w-48 rounded-xl border border-white/15 bg-night-900/95 py-1.5 shadow-2xl shadow-night-950/50 backdrop-blur-md">
                        @foreach ($locales as $code => $meta)
                            <a href="{{ route('locale.switch', $code) }}"
                               @if ($code === $currentLocale) aria-current="true" @endif
                               class="flex items-center justify-between px-4 py-2.5 text-[12px] transition-colors {{ $code === $currentLocale ? 'text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                                <span>{{ $meta['label'] }}</span>
                                @if ($code === $currentLocale)
                                    <span class="size-1.5 rounded-full bg-ember-500"></span>
                                @else
                                    <span class="label-xs text-white/30">{{ $meta['short'] }}</span>
                                @endif
                            </a>
                        @endforeach
                        </div>
                    </div>

                @if ($authenticated)
                    <a href="{{ route('admin.quotations.index') }}"
                       class="label-xs hidden items-center gap-2 rounded-full border border-white/20 px-4 py-2.5 text-white/80 transition-colors duration-300 hover:border-ember-500 hover:text-white sm:flex">
                        <x-icons.user class="size-3.5" />
                        {{ $authenticated->name }}
                    </a>

                    <form method="POST" action="{{ route('admin.logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit" aria-label="{{ __('admin.logout') }}" data-tooltip="{{ __('admin.logout') }}"
                                class="grid size-10 place-items-center rounded-full border border-white/20 text-white/70 transition-colors duration-300 hover:border-red-400/60 hover:text-red-200">
                            <x-icons.logout class="size-4" />
                        </button>
                    </form>
                @else
                    <a href="{{ route('admin.login') }}"
                       class="label-xs hidden items-center gap-2 rounded-full border border-white/20 px-4 py-2.5 text-white/80 transition-colors duration-300 hover:border-ember-500 hover:bg-ember-500 hover:text-white sm:flex">
                        <x-icons.lock class="size-3.5" />
                        {{ __('landing.nav.restricted') }}
                    </a>
                @endif

                <button type="button" @click="menu = true" aria-label="{{ __('landing.actions.open_menu') }}"
                        class="grid size-9 place-items-center text-white lg:hidden">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                        <path d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-cloak x-show="menu" x-transition.opacity class="fixed inset-0 z-50 bg-night-950/95 backdrop-blur-sm lg:hidden">
        <div class="flex h-full flex-col px-6 py-4">
            <div class="flex items-center justify-between border-b border-white/15 pb-4">
                <span class="flex items-center gap-3">
                    <img src="{{ asset('assets/icon.png') }}" alt="" aria-hidden="true" class="size-9 shrink-0">
                    <span class="font-display text-sm font-extrabold uppercase tracking-[0.24em]">{{ __('landing.brand.name') }}</span>
                </span>
                <button type="button" @click="menu = false" aria-label="{{ __('landing.actions.close_menu') }}"
                        class="grid size-9 place-items-center">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                        <path d="m6 6 12 12M18 6 6 18"/>
                    </svg>
                </button>
            </div>

            <nav class="flex flex-1 flex-col justify-center gap-6">
                @foreach ($navigation as $item)
                    <a href="{{ $item['url'] }}" @click="menu = false"
                       class="font-display text-3xl font-bold uppercase tracking-tight {{ $item['active'] ? 'text-white' : 'text-white/50' }}">
                        {{ __('landing.nav.'.$item['key']) }}
                    </a>
                @endforeach

                @if ($authenticated)
                    <a href="{{ route('admin.quotations.index') }}" @click="menu = false"
                       class="label-xs mt-2 flex w-max items-center gap-2 rounded-full border border-white/20 px-5 py-3 text-white/80">
                        <x-icons.user class="size-3.5" />
                        {{ $authenticated->name }}
                    </a>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                                class="label-xs flex w-max items-center gap-2 rounded-full border border-white/20 px-5 py-3 text-white/60">
                            <x-icons.logout class="size-3.5" />
                            {{ __('admin.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('admin.login') }}" @click="menu = false"
                       class="label-xs mt-2 flex w-max items-center gap-2 rounded-full border border-white/20 px-5 py-3 text-white/80">
                        <x-icons.lock class="size-3.5" />
                        {{ __('landing.nav.restricted') }}
                    </a>
                @endif
            </nav>

            <div class="border-t border-white/15 pt-5">
                <p class="label-xs mb-4 text-white/40">{{ __('landing.actions.language') }}</p>
                <div class="flex flex-wrap gap-3">
                    @foreach ($locales as $code => $meta)
                        <a href="{{ route('locale.switch', $code) }}"
                           class="label-xs rounded-lg border px-4 py-2.5 transition-colors {{ $code === $currentLocale ? 'border-ember-500 text-white' : 'border-white/20 text-white/60 hover:border-white/50 hover:text-white' }}">
                            {{ $meta['short'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</header>
