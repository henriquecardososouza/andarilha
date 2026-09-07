<section class="relative pb-20 lg:pb-28">
    <div class="mx-auto max-w-[1180px] px-6">
        <div class="grid gap-8 border-y border-white/10 py-12 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            @foreach ($stats as $stat)
                <x-about::stat :stat="$stat" />
            @endforeach
        </div>
    </div>
</section>
