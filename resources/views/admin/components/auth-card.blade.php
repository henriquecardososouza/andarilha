@props(['heading', 'lead' => null, 'back' => null])

<div class="w-full max-w-sm" data-reveal>
    <a href="{{ route('landing') }}" class="mb-10 flex justify-center">
        <img src="{{ asset('assets/logo.png') }}"
             alt="{{ __('landing.brand.name') }}: {{ __('landing.brand.slogan') }}"
             class="h-16 w-auto">
    </a>

    <div class="rounded-2xl border border-white/10 bg-night-950/55 p-7 backdrop-blur-md lg:p-8">
        <div class="mb-8">
            <h1 class="font-display text-base font-bold uppercase tracking-[0.1em] text-white">{{ $heading }}</h1>
            @if ($lead)
                <p class="mt-2 text-[11px] leading-relaxed text-white/45">{{ $lead }}</p>
            @endif
        </div>

        {{ $slot }}
    </div>

    <a href="{{ $back ?? route('landing') }}"
       class="label-xs mt-8 flex items-center justify-center gap-2.5 text-white/40 transition-colors hover:text-white">
        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 12H5m5 5-5-5 5-5"/>
        </svg>
        {{ $back ? __('admin.back_to_login') : __('admin.back_to_site') }}
    </a>
</div>
