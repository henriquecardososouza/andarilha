@extends("layouts.admin-auth")

@section("title", __("admin.verify.meta"))

@section("content")
    <x-admin::auth-card :heading="__('admin.verify.heading')" :lead="__('admin.verify.lead')">
        <p class="text-[12px] leading-[1.9] text-white/60">
            {{ __('admin.verify.body', ['email' => auth()->user()->email]) }}
        </p>

        <form method="POST" action="{{ route('admin.verification.send') }}">
            @csrf
            <x-admin::submit>{{ __('admin.verify.resend') }}</x-admin::submit>
        </form>

        <form method="POST" action="{{ route('admin.logout') }}" class="mt-5 text-center">
            @csrf
            <button type="submit" class="text-[12px] text-white/45 transition-colors hover:text-white">
                {{ __('admin.logout') }}
            </button>
        </form>
    </x-admin::auth-card>
@endsection
