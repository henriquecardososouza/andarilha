@extends("layouts.app")

@section("title", __("pages.about.meta.title"))
@section("description", __("pages.about.meta.description"))

@section("content")
    <x-page-banner
        :image="$banner?->image()"
        :eyebrow="__('landing.brand.slogan')"
        :title="__('pages.about.banner.title')"
        :lead="__('pages.about.banner.lead')" />

    @include("about.partials.story", ["images" => $storyImages])
    @include("about.partials.stats", ["stats" => $stats])
    @include("about.partials.team", ["team" => $team])
    @include("about.partials.cta")
@endsection
