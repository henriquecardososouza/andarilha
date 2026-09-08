@extends("layouts.admin-auth")

@section("title", __("admin.blocked.meta"))

@section("content")
    <x-admin::auth-card :heading="__('admin.blocked.heading')" :lead="__('admin.blocked.lead')">
        <p class="text-[12px] leading-[1.9] text-white/60">
            {{ __('admin.blocked.body') }}
        </p>

        <form method="POST" action="{{ route('admin.logout') }}" class="mt-7">
            @csrf
            <x-admin::submit>{{ __('admin.logout') }}</x-admin::submit>
        </form>
    </x-admin::auth-card>
@endsection
