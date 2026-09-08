@extends("layouts.admin")

@section("title", __("admin.quotations.meta"))

@section("content")
    <x-admin::page-header
        :title="__('admin.quotations.title')"
        :description="__('admin.quotations.subtitle', ['total' => $quotations->total()])" />

    <x-admin::table-toolbar
        :endpoint="$action"
        :search="$filters->search"
        :placeholder="__('admin.quotations.search')"
        :filter-keys="['status', 'destiny', 'trip_from', 'trip_until']"
        filters-modal="quotation-filters" />

    <div class="mt-6">
        <x-admin::async-table :endpoint="$action">
            <x-admin::quotations.table :quotations="$quotations" />
        </x-admin::async-table>
    </div>

    <x-admin::quotations.filters-modal
        :filters="$filters"
        :status-options="$statusOptions"
        :status-selected="$statusSelected"
        :destiny-selected="$destinySelected"
        :destinies-endpoint="$destiniesEndpoint"
        :action="$action" />

    <x-admin::quotations.answer-modal :config="$answerConfig" />
@endsection

