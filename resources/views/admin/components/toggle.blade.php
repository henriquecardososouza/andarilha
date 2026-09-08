@props(['active', 'endpoint', 'onLabel', 'offLabel'])

<button type="button"
        x-data="toggleSwitch({{ Js::from((bool) $active) }}, {{ Js::from($endpoint) }})"
        @click="flip()"
        role="switch"
        :aria-checked="on ? 'true' : 'false'"
        :aria-label="on ? {{ Js::from($onLabel) }} : {{ Js::from($offLabel) }}"
        :disabled="busy"
        :class="on ? 'bg-ember-500' : 'bg-white/15'"
        class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full transition-colors duration-300 disabled:opacity-60">
    <span class="inline-block size-3.5 rounded-full bg-white shadow transition-transform duration-300 ease-out"
          :class="on ? 'translate-x-[1.15rem]' : 'translate-x-[0.15rem]'"></span>
</button>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('toggleSwitch', (initial, endpoint) => ({
            on: initial,
            busy: false,

            async flip() {
                if (this.busy) {
                    return
                }

                this.on = ! this.on
                this.busy = true

                const body = new FormData()
                body.append('_method', 'PATCH')
                body.append('_token', document.querySelector('meta[name="csrf-token"]').content)

                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body,
                    })

                    const payload = await response.json().catch(() => ({}))

                    if (! response.ok) {
                        this.on = ! this.on
                    }

                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { type: response.ok ? 'success' : 'error', message: payload.message },
                    }))
                } catch (error) {
                    this.on = ! this.on
                } finally {
                    this.busy = false
                }
            },
        }))
    })
</script>
@endPushOnce
