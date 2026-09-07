<section class="relative pb-20 lg:pb-28">
    <div class="mx-auto max-w-[1180px] px-6">
        <x-section-heading data-reveal>{{ __('pages.about.team.heading') }}</x-section-heading>

        <div class="mt-12 grid gap-6 lg:mt-16 lg:grid-cols-3" data-reveal="120">
            @foreach ($team as $member)
                <x-about::team-member :member="$member" />
            @endforeach
        </div>
    </div>
</section>
