@extends("layouts.admin-auth")

@section("title", __("admin.reset.meta"))

@section("content")
    <x-admin::auth-card
        :heading="__('admin.reset.heading')"
        :lead="__('admin.reset.lead')"
        :back="route('admin.login')">
        <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <x-admin::field
                name="email"
                type="email"
                :label="__('admin.login.form.email')"
                :value="$email"
                required />

            <x-admin::field
                name="password"
                type="password"
                :label="__('admin.reset.form.password')"
                :placeholder="__('admin.reset.form.password_placeholder')"
                required
                autofocus />

            <x-admin::field
                name="password_confirmation"
                type="password"
                :label="__('admin.reset.form.confirmation')"
                :placeholder="__('admin.reset.form.confirmation_placeholder')"
                required />

            <x-admin::submit>{{ __('admin.reset.submit') }}</x-admin::submit>
        </form>
    </x-admin::auth-card>
@endsection
