@props(['filters', 'statusOptions', 'statusSelected', 'destinySelected', 'destiniesEndpoint', 'action'])

<x-admin::modal
    name="quotation-filters"
    :title="__('admin.quotations.filters.title')"
    :description="__('admin.quotations.filters.description')">

    <form x-data="tableFilters({{ Js::from($action) }})" @submit.prevent="submit($el)" class="space-y-5">
        <x-form.select
            name="status"
            :label="__('admin.quotations.columns.status')"
            :placeholder="__('admin.quotations.filters.any')"
            :clear-label="__('admin.quotations.filters.any')"
            :options="$statusOptions"
            :selected="$statusSelected" />

        <x-form.select
            name="destiny"
            :label="__('admin.quotations.columns.destiny')"
            :placeholder="__('admin.quotations.filters.any')"
            :clear-label="__('admin.quotations.filters.any')"
            :endpoint="$destiniesEndpoint"
            :selected="$destinySelected" />

        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.date name="trip_from" :label="__('admin.quotations.filters.trip_from')" :value="$filters->tripFrom" />
            <x-form.date name="trip_until" :label="__('admin.quotations.filters.trip_until')" :value="$filters->tripUntil" />
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                    class="label-xs flex-1 rounded-lg bg-ember-500 py-3.5 text-white transition-colors hover:bg-ember-600">
                {{ __('admin.quotations.filters.apply') }}
            </button>

            <button type="button" @click="clear($root)"
                    class="label-xs rounded-lg border border-white/15 px-5 py-3.5 text-white/60 transition-colors hover:border-white/40 hover:text-white">
                {{ __('admin.quotations.filters.clear') }}
            </button>
        </div>
    </form>
</x-admin::modal>
