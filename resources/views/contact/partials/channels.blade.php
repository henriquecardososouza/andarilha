<section class="relative py-20 lg:py-28">
    <div class="mx-auto max-w-[1180px] px-6">
        <x-section-heading data-reveal>{{ __('pages.contact.channels.heading') }}</x-section-heading>

        <div class="mt-12 grid gap-6 lg:mt-16 lg:grid-cols-3" data-reveal="120">
            @foreach ($channels as $channel)
                <x-contact::channel :channel="$channel" />
            @endforeach
        </div>

        <p class="mt-8 flex items-center gap-2.5 text-[12px] text-white/45" data-reveal="200">
            <x-icons.clock class="size-4 shrink-0 text-white/30" />
            {{ __('pages.contact.hours') }}
        </p>
    </div>
</section>
