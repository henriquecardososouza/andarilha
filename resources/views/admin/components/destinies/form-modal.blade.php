@props(['action'])

<x-admin::modal name="destiny-form" :title="__('admin.destinies.form.title')" :description="__('admin.destinies.form.hint')">
    <x-admin::ajax-form :action="$action" modal="destiny-form" data-failure="{{ __('landing.contact.feedback.failed') }}">
        <x-admin::field name="name" :label="__('admin.destinies.form.name')"
            :placeholder="__('admin.destinies.form.name_placeholder')" required />
        <x-admin::field name="country" :label="__('admin.destinies.form.country')"
            :placeholder="__('admin.destinies.form.country_placeholder')" required />
        <x-admin::field name="postal_code" :label="__('admin.destinies.form.postal_code')"
            :placeholder="__('admin.destinies.form.postal_code_placeholder')" />

        <label for="destiny-active" class="flex items-center gap-3 text-[12px] text-white/70">
            <input id="destiny-active" name="active" type="checkbox" value="1" checked
                   class="size-4 rounded border-white/20 bg-white/[0.03] accent-ember-500">
            {{ __('admin.destinies.form.active') }}
        </label>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" :disabled="submitting"
                    class="label-xs flex-1 rounded-lg bg-ember-500 py-3.5 text-white transition-colors hover:bg-ember-600 disabled:cursor-wait disabled:opacity-60">
                {{ __('admin.destinies.form.submit') }}
            </button>

            <button type="button" @click="$dispatch('close-modal')"
                    class="label-xs rounded-lg border border-white/15 px-5 py-3.5 text-white/60 transition-colors hover:border-white/40 hover:text-white">
                {{ __('admin.cancel') }}
            </button>
        </div>
    </x-admin::ajax-form>
</x-admin::modal>
