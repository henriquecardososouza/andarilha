<header x-data="{ menu: false }" class="relative z-40 border-b border-white/10 bg-night-950/70 backdrop-blur-md">
    <div class="mx-auto flex max-w-[1400px] items-center justify-between gap-6 px-6 py-4">
        <a href="{{ route('admin.quotations.index') }}" class="flex shrink-0 items-center gap-3">
            <img src="{{ asset('assets/icon.png') }}" alt="" aria-hidden="true" class="size-9 shrink-0">
            <span class="flex flex-col leading-none">
                <span class="font-display text-sm font-extrabold uppercase tracking-[0.14em] text-ember-500">
                    {{ __('landing.brand.name') }}
                </span>
                <span class="mt-1 text-[10px] uppercase tracking-[0.16em] text-white/35">
                    {{ __('admin.area') }}
                </span>
            </span>
        </a>

        <nav class="hidden lg:flex lg:items-center lg:gap-7">
            @foreach ($panelNavigation as $item)
                <a href="{{ $item['url'] }}"
                   @if ($item['active']) aria-current="page" @endif
                   class="label-xs relative py-2 transition-colors {{ $item['active'] ? 'text-white' : 'text-white/55 hover:text-white' }}">
                    {{ __('admin.nav.'.$item['key']) }}
                    @if ($item['active'])
                        <span class="absolute inset-x-0 -bottom-[17px] h-0.5 bg-ember-500"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('landing') }}"
               class="label-xs hidden items-center gap-2 rounded-full border border-white/15 px-4 py-2.5 text-white/70 transition-colors duration-300 hover:border-white/40 hover:text-white sm:flex">
                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 12H5m5 5-5-5 5-5"/>
                </svg>
                {{ __('admin.nav.back_to_site') }}
            </a>

            <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false" class="relative">
                <button type="button" @click="open = !open" :aria-expanded="open" aria-haspopup="true"
                        class="flex items-center gap-2.5 rounded-full border border-white/15 py-1.5 pl-1.5 pr-3 transition-colors hover:border-white/40">
                    <span aria-hidden="true"
                          class="grid size-7 shrink-0 place-items-center rounded-full bg-ember-500/15 text-[10px] font-semibold text-ember-400">
                        {{ $userInitials }}
                    </span>
                    <span class="hidden text-[12px] text-white/80 sm:block">{{ $user->name }}</span>
                    <svg class="size-3 text-white/40 transition-transform duration-200" :class="open && 'rotate-180'"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>

                <div x-cloak x-show="open"
                     x-transition:enter="transition duration-200 ease-out"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition duration-150 ease-in"
                     x-transition:leave-end="opacity-0"
                     class="absolute right-0 top-full z-50 mt-3 w-56 rounded-xl border border-white/15 bg-night-900/95 p-1.5 shadow-2xl shadow-night-950/60 backdrop-blur-md">
                    <div class="border-b border-white/10 px-3 pb-3 pt-2">
                        <p class="truncate text-[12px] text-white">{{ $user->name }}</p>
                        <p class="truncate text-[11px] text-white/40">{{ $user->email }}</p>
                    </div>

                    <a href="{{ route('admin.profile.show') }}"
                       class="mt-1.5 flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-[12px] text-white/70 transition-colors hover:bg-white/5 hover:text-white">
                        <x-icons.user class="size-4 shrink-0 text-white/35" />
                        {{ __('admin.nav.profile') }}
                    </a>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2.5 text-left text-[12px] text-white/70 transition-colors hover:bg-red-400/10 hover:text-red-200">
                            <x-icons.logout class="size-4 shrink-0 text-white/35" />
                            {{ __('admin.logout') }}
                        </button>
                    </form>
                </div>
            </div>

            <button type="button" @click="menu = ! menu" aria-label="{{ __('landing.actions.open_menu') }}"
                    class="grid size-9 place-items-center text-white lg:hidden">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                    <path d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>
    </div>

    <nav x-cloak x-show="menu" x-transition class="border-t border-white/10 px-6 py-4 lg:hidden">
        <div class="flex flex-col gap-1">
            @foreach ($panelNavigation as $item)
                <a href="{{ $item['url'] }}"
                   class="label-xs rounded-lg px-3 py-3 transition-colors {{ $item['active'] ? 'bg-white/5 text-white' : 'text-white/55 hover:text-white' }}">
                    {{ __('admin.nav.'.$item['key']) }}
                </a>
            @endforeach

            <a href="{{ route('landing') }}" class="label-xs rounded-lg px-3 py-3 text-white/55 transition-colors hover:text-white">
                {{ __('admin.nav.back_to_site') }}
            </a>
        </div>
    </nav>
</header>
