<section class="relative py-20 lg:py-28">
    <div class="mx-auto max-w-[1180px] px-6">
        <x-section-heading data-reveal>{{ __('pages.contact.faq.heading') }}</x-section-heading>

        <div x-data="{ open: 0 }" class="mx-auto mt-12 max-w-3xl lg:mt-16" data-reveal="120">
            @foreach ($questions as $key)
                <x-contact::faq-item :question="$key" :index="$loop->index" />
            @endforeach
        </div>
    </div>
</section>
