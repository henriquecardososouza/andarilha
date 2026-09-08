@props(['action'])

<x-admin::modal name="new-user" :title="__('admin.users.create')" :description="__('admin.users.create_hint')">
    <x-admin::ajax-form :action="$action" modal="new-user" data-failure="{{ __('landing.contact.feedback.failed') }}">
        <x-admin::field name="name" :label="__('admin.users.form.name')"
            :placeholder="__('admin.users.form.name_placeholder')" required />
        <x-admin::field name="email" type="email" :label="__('admin.users.form.email')"
            :placeholder="__('admin.login.form.email_placeholder')" required />

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" :disabled="submitting"
                    class="label-xs flex-1 rounded-lg bg-ember-500 py-3.5 text-white transition-colors hover:bg-ember-600 disabled:cursor-wait disabled:opacity-60">
                {{ __('admin.users.create_submit') }}
            </button>

            <button type="button" @click="$dispatch('close-modal')"
                    class="label-xs rounded-lg border border-white/15 px-5 py-3.5 text-white/60 transition-colors hover:border-white/40 hover:text-white">
                {{ __('admin.cancel') }}
            </button>
        </div>
    </x-admin::ajax-form>
</x-admin::modal>
