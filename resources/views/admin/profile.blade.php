@extends("layouts.admin")

@section("title", __("admin.profile.meta"))

@section("content")
    <x-admin::page-header
        :title="__('admin.profile.title')"
        :description="__('admin.profile.subtitle')" />

    <div class="grid max-w-4xl gap-6 lg:grid-cols-2">
        <section class="rounded-2xl border border-white/10 bg-night-900 p-7">
            <h2 class="font-display text-sm font-bold uppercase tracking-[0.1em] text-white">
                {{ __('admin.profile.details_title') }}
            </h2>
            <p class="mt-2 text-[11px] leading-relaxed text-white/45">{{ __('admin.profile.details_hint') }}</p>

            <x-admin::ajax-form :action="$updateAction" method="PATCH" class="mt-6 space-y-5"
                                data-failure="{{ __('landing.contact.feedback.failed') }}">
                <x-admin::field name="name" :label="__('admin.profile.form.name')"
                    :value="$user->name"
                    :placeholder="__('admin.users.form.name_placeholder')" required />

                <div>
                    <x-form.label for="profile-email">{{ __('admin.profile.form.email') }}</x-form.label>
                    <input id="profile-email" type="email" value="{{ $user->email }}" disabled
                           class="w-full cursor-not-allowed rounded-lg border border-white/10 bg-white/[0.02] px-4 py-3 text-sm text-white/40 outline-none">
                    <p class="mt-2 text-[11px] text-white/35">{{ __('admin.profile.email_locked') }}</p>
                </div>

                <button type="submit" :disabled="submitting"
                        class="label-xs w-full rounded-lg bg-ember-500 py-3.5 text-white transition-colors hover:bg-ember-600 disabled:cursor-wait disabled:opacity-60">
                    {{ __('admin.profile.save_details') }}
                </button>
            </x-admin::ajax-form>
        </section>

        <section class="rounded-2xl border border-white/10 bg-night-900 p-7">
            <h2 class="font-display text-sm font-bold uppercase tracking-[0.1em] text-white">
                {{ __('admin.profile.password_title') }}
            </h2>
            <p class="mt-2 text-[11px] leading-relaxed text-white/45">{{ __('admin.profile.password_hint') }}</p>

            <x-admin::ajax-form :action="$passwordAction" method="PATCH" class="mt-6 space-y-5"
                                data-failure="{{ __('landing.contact.feedback.failed') }}">
                <x-admin::field name="current_password" type="password"
                    :label="__('admin.profile.form.current_password')"
                    :placeholder="__('admin.login.form.password_placeholder')" required />

                <x-admin::field name="password" type="password"
                    :label="__('admin.profile.form.new_password')"
                    :placeholder="__('admin.reset.form.password_placeholder')" required />

                <x-admin::field name="password_confirmation" type="password"
                    :label="__('admin.users.form.confirmation')"
                    :placeholder="__('admin.reset.form.confirmation_placeholder')" required />

                <button type="submit" :disabled="submitting"
                        class="label-xs w-full rounded-lg bg-ember-500 py-3.5 text-white transition-colors hover:bg-ember-600 disabled:cursor-wait disabled:opacity-60">
                    {{ __('admin.profile.save_password') }}
                </button>
            </x-admin::ajax-form>
        </section>
    </div>
@endsection
