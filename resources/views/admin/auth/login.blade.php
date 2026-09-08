@extends("layouts.admin-auth")

@section("title", __("admin.login.meta"))

@section("content")
    <x-admin::auth-card :heading="__('admin.login.heading')" :lead="__('admin.login.lead')">
        <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
            @csrf

            <x-admin::field
                name="email"
                type="email"
                :label="__('admin.login.form.email')"
                :placeholder="__('admin.login.form.email_placeholder')"
                required
                autofocus />

            <x-admin::field
                name="password"
                type="password"
                :label="__('admin.login.form.password')"
                :placeholder="__('admin.login.form.password_placeholder')"
                required />

            <div class="flex items-center justify-between gap-4">
                <label for="admin-remember" class="flex items-center gap-2.5 text-[12px] text-white/55">
                    <input id="admin-remember" name="remember" type="checkbox" value="1"
                           class="size-4 rounded border-white/20 bg-white/[0.03] accent-ember-500">
                    {{ __('admin.login.form.remember') }}
                </label>

                <a href="{{ route('admin.password.request') }}"
                   class="text-[12px] text-white/45 transition-colors hover:text-ember-400">
                    {{ __('admin.login.forgot') }}
                </a>
            </div>

            <x-admin::submit>{{ __('admin.login.form.submit') }}</x-admin::submit>
        </form>
    </x-admin::auth-card>
@endsection

