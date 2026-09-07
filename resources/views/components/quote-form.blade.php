<form method="POST" action="{{ $action }}"
      x-data="quoteForm({{ Js::from($feedback) }})"
      @submit.prevent="submit()"
      class="rounded-2xl border border-white/10 bg-night-950/55 p-7 backdrop-blur-md lg:p-8"
      data-reveal="120">
    @csrf

    <div class="space-y-5">
        <x-form.input
            name="name"
            :label="__('landing.contact.form.name')"
            :placeholder="__('landing.contact.form.name_placeholder')"
            maxlength="100"
            required />

        <x-form.input
            name="email"
            type="email"
            :label="__('landing.contact.form.email')"
            :placeholder="__('landing.contact.form.email_placeholder')"
            maxlength="150"
            required />

        <x-form.select
            name="destiny_uuid"
            :label="__('landing.contact.form.destination')"
            :placeholder="__('landing.contact.form.destination_placeholder')"
            :endpoint="$destiniesEndpoint" />

        <x-form.date
            name="trip_date"
            :label="__('landing.contact.form.date')"
            :placeholder="__('landing.contact.form.date_placeholder')"
            :min="$earliestDate"
            required />
    </div>

    <button type="submit" :disabled="submitting"
            class="label-xs group mt-9 flex w-full items-center justify-center gap-3 rounded-lg bg-ember-500 py-4 text-white transition-colors duration-300 hover:bg-ember-600 disabled:cursor-wait disabled:opacity-80">
        <template x-if="submitting">
            <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.5" class="opacity-25"/>
                <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </template>

        <span x-text="submitting
            ? {{ Js::from(__('landing.contact.form.submitting')) }}
            : {{ Js::from(__('landing.contact.form.submit')) }}"></span>

        <template x-if="! submitting">
            <svg class="size-3.5 transition-transform duration-300 group-hover:translate-x-1"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 12h15m-5-5 5 5-5 5"/>
            </svg>
        </template>
    </button>
</form>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('quoteForm', (labels) => ({
            submitting: false,
            errors: {},
            labels,

            async submit() {
                if (this.submitting) {
                    return
                }

                this.submitting = true
                this.errors = {}

                try {
                    const response = await fetch(this.$el.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': this.$el.querySelector('input[name="_token"]').value,
                        },
                        body: new FormData(this.$el),
                    })

                    if (response.status === 422) {
                        const payload = await response.json()
                        this.errors = payload.errors ?? {}
                        this.notify('error', this.labels.invalid)

                        return
                    }

                    if (! response.ok) {
                        throw new Error(`Unexpected status ${response.status}`)
                    }

                    const payload = await response.json()
                    this.notify('success', payload.message ?? this.labels.success)
                    this.reset()
                } catch (error) {
                    this.notify('error', this.labels.failed)
                } finally {
                    this.submitting = false
                }
            },

            reset() {
                this.$el.reset()
                this.$dispatch('quote-reset')
            },

            notify(type, message) {
                window.dispatchEvent(new CustomEvent('toast', { detail: { type, message } }))
            },
        }))

        window.Alpine.data('searchSelect', (config) => ({
            endpoint: config.endpoint,
            placeholder: config.placeholder ?? '',
            searchingLabel: config.searchingLabel ?? '',
            emptyLabel: config.emptyLabel ?? '',

            open: false,
            loading: false,
            query: '',
            options: [],
            highlighted: 0,

            value: config.initial?.value ?? '',
            selectedLabel: config.initial?.label ?? '',

            debounce: null,
            request: 0,

            toggle() {
                this.open ? this.close() : this.show()
            },

            show() {
                this.open = true
                this.$nextTick(() => this.$refs.search?.focus())

                if (! this.options.length) {
                    this.load()
                }
            },

            close() {
                this.open = false
            },

            search() {
                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => this.load(), 250)
            },

            async load() {
                const ticket = ++this.request

                this.loading = true

                try {
                    const url = new URL(this.endpoint, window.location.origin)
                    url.searchParams.set('q', this.query)

                    const response = await fetch(url, { headers: { Accept: 'application/json' } })
                    const payload = await response.json()

                    if (ticket !== this.request) {
                        return
                    }

                    this.options = payload.data ?? []
                    this.highlighted = 0
                } catch (error) {
                    if (ticket === this.request) {
                        this.options = []
                    }
                } finally {
                    if (ticket === this.request) {
                        this.loading = false
                    }
                }
            },

            choose(option) {
                this.value = option.value
                this.selectedLabel = option.label
                this.close()
                this.$refs.button?.focus()
            },

            move(step) {
                if (! this.open) {
                    return this.show()
                }

                if (this.options.length) {
                    this.highlighted = (this.highlighted + step + this.options.length) % this.options.length
                }
            },

            pick() {
                if (! this.open) {
                    return this.show()
                }

                if (this.options[this.highlighted]) {
                    this.choose(this.options[this.highlighted])
                }
            },

            reset() {
                this.value = ''
                this.selectedLabel = ''
                this.query = ''
                this.options = []
                this.close()
            },
        }))
    })
</script>
@endPushOnce
