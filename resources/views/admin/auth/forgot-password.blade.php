@extends("layouts.admin-auth")

@section("title", __("admin.forgot.meta"))

@section("content")
    <x-admin::auth-card
        :heading="__('admin.forgot.heading')"
        :lead="__('admin.forgot.lead')"
        :back="route('admin.login')">
        <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-5">
            @csrf

            <x-admin::field
                name="email"
                type="email"
                :label="__('admin.login.form.email')"
                :placeholder="__('admin.login.form.email_placeholder')"
                required
                autofocus />

            <x-admin::submit>{{ __('admin.forgot.submit') }}</x-admin::submit>
        </form>
    </x-admin::auth-card>
@endsection
