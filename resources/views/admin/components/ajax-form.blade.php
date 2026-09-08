@props(['action', 'method' => 'POST', 'modal' => null])

@php
    $config = ['action' => $action, 'method' => $method, 'modal' => $modal];
@endphp

<form method="POST" :action="action"
      x-data="adminForm({{ Js::from($config) }})"
      @submit.prevent="submit()"
      @open-modal.window="fill($event.detail)"
      {{ $attributes->class(['space-y-5']) }}>
    @csrf
    <input type="hidden" name="_method" :value="method">

    {{ $slot }}
</form>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('adminForm', (config) => ({
            action: config.action,
            method: config.method,
            submitting: false,
            errors: {},

            fill(detail) {
                if (! detail || (config.modal && detail.modal !== config.modal)) {
                    return
                }

                this.errors = {}
                this.action = detail.action ?? config.action
                this.method = detail.method ?? config.method

                this.$el.reset()

                Object.entries(detail.fields ?? {}).forEach(([name, value]) => {
                    const field = this.$el.querySelector(`[name="${name}"]`)

                    if (! field) {
                        return
                    }

                    field.type === 'checkbox' ? (field.checked = Boolean(value)) : (field.value = value ?? '')
                })
            },

            async submit() {
                if (this.submitting) {
                    return
                }

                this.submitting = true
                this.errors = {}

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': this.$el.querySelector('input[name="_token"]').value,
                        },
                        body: new FormData(this.$el),
                    })

                    const payload = await response.json().catch(() => ({}))

                    if (response.status === 422) {
                        this.errors = payload.errors ?? {}

                        if (! payload.errors && payload.message) {
                            this.notify('error', payload.message)
                        }

                        return
                    }

                    if (! response.ok) {
                        throw new Error(`Unexpected status ${response.status}`)
                    }

                    this.notify('success', payload.message)
                    this.$el.reset()
                    window.dispatchEvent(new CustomEvent('close-modal'))
                    window.dispatchEvent(new CustomEvent('table-reload'))
                } catch (error) {
                    this.notify('error', this.$el.dataset.failure)
                } finally {
                    this.submitting = false
                }
            },

            notify(type, message) {
                if (message) {
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type, message } }))
                }
            },
        }))
    })
</script>
@endPushOnce
