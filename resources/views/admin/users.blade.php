@extends("layouts.admin")

@section("title", __("admin.users.meta"))

@section("content")
    <x-admin::page-header
        :title="__('admin.users.title')"
        :description="__('admin.users.subtitle', ['total' => $users->total()])" />

    <x-admin::table-toolbar
        :endpoint="$action"
        :search="$search"
        :placeholder="__('admin.users.search')">
        <button type="button" x-data
                @click="$dispatch('open-modal', { modal: 'new-user' })"
                class="label-xs flex shrink-0 items-center gap-2.5 rounded-lg bg-ember-500 px-5 py-3 text-white transition-colors hover:bg-ember-600">
            <x-icons.user class="size-4" />
            {{ __('admin.users.create') }}
        </button>
    </x-admin::table-toolbar>

    <div class="mt-6">
        <x-admin::async-table :endpoint="$action">
            <x-admin::users.table :users="$users" :currentUser="$currentUser" />
        </x-admin::async-table>
    </div>

    <x-admin::users.create-modal :action="$storeAction" />
@endsection



