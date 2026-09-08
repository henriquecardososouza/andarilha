@extends("layouts.admin")

@section("title", __("admin.destinies.meta"))

@section("content")
    <x-admin::page-header
        :title="__('admin.destinies.title')"
        :description="__('admin.destinies.subtitle', ['total' => $destinies->total()])" />

    <x-admin::table-toolbar
        :endpoint="$action"
        :search="$search"
        :placeholder="__('admin.destinies.search')">
        <button type="button" x-data
                @click="$dispatch('open-modal', { modal: 'destiny-form', action: {{ Js::from($storeAction) }}, method: 'POST', fields: {} })"
                class="label-xs flex shrink-0 items-center gap-2.5 rounded-lg bg-ember-500 px-5 py-3 text-white transition-colors hover:bg-ember-600">
            <x-icons.pin class="size-4" />
            {{ __('admin.destinies.create') }}
        </button>
    </x-admin::table-toolbar>

    <div class="mt-6">
        <x-admin::async-table :endpoint="$action">
            <x-admin::destinies.table :destinies="$destinies" />
        </x-admin::async-table>
    </div>

    <x-admin::destinies.form-modal :action="$storeAction" />
@endsection
