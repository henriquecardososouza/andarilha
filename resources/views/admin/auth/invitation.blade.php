@extends("layouts.admin-auth")

@section("title", __("admin.invite.meta"))

@section("content")
    <x-admin::auth-card
        :heading="__('admin.invite.heading')"
        :lead="__('admin.invite.lead')">
        <form method="POST" action="{{ route('admin.invitation.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <x-form.label for="invitation-email">{{ __('admin.login.form.email') }}</x-form.label>
                <input id="invitation-email" type="email" value="{{ $email }}" disabled
                       class="w-full cursor-not-allowed rounded-lg border border-white/10 bg-white/[0.02] px-4 py-3 text-sm text-white/40 outline-none">
            </div>

            <x-admin::field
                name="password"
                type="password"
                :label="__('admin.invite.form.password')"
                :placeholder="__('admin.reset.form.password_placeholder')"
                required
                autofocus />

            <x-admin::field
                name="password_confirmation"
                type="password"
                :label="__('admin.invite.form.confirmation')"
                :placeholder="__('admin.reset.form.confirmation_placeholder')"
                required />

            <x-admin::submit>{{ __('admin.invite.submit') }}</x-admin::submit>
        </form>
    </x-admin::auth-card>
@endsection
