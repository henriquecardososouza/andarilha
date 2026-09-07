@extends("layouts.app")

@section("title", __("pages.contact.meta.title"))
@section("description", __("pages.contact.meta.description"))

@section("content")
    <x-page-banner
        :image="$banner?->image()"
        :eyebrow="__('landing.brand.slogan')"
        :title="__('pages.contact.banner.title')"
        :lead="__('pages.contact.banner.lead')" />

    @include("contact.partials.channels", ["channels" => $channels])
    @include("contact.partials.quote", ["backdrop" => $backdrop])
    @include("contact.partials.faq", ["questions" => $questions])
@endsection
