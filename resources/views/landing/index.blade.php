@extends("layouts.app")

@section("title", __("landing.meta.title"))
@section("description", __("landing.meta.description"))

@section("content")
    @include("landing.partials.hero", ["slides" => $slides])
    @include("landing.partials.destinations", ["slides" => $slides])
    @include("landing.partials.quote", ["backdrop" => $backdrop])
@endsection

