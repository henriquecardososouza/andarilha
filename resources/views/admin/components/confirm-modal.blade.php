<div x-data="confirmDialog" @confirm-action.window="ask($event.detail)" x-cloak x-show="open"
     @keydown.escape.window="cancel()"
     class="fixed inset-0 z-[90] grid place-items-center bg-night-950/85 p-6 backdrop-blur-sm">
    <div x-show="open"
         x-transition:enter="transition duration-200 ease-out"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition duration-150 ease-in"
         x-transition:leave-end="opacity-0 scale-95"
         @click.outside="cancel()"
         role="alertdialog" aria-modal="true"
         class="w-full max-w-sm rounded-2xl border border-white/10 bg-night-900 p-7 shadow-2xl shadow-night-950/70">
        <div class="flex items-start gap-4">
            <span class="grid size-10 shrink-0 place-items-center rounded-full bg-red-400/15 text-red-300">
                <x-icons.trash class="size-5" />
            </span>
            <div>
                <h2 class="font-display text-sm font-bold uppercase tracking-[0.1em] text-white">
                    {{ __('admin.confirm.title') }}
                </h2>
                <p class="mt-2 text-[12px] leading-relaxed text-white/60" x-text="message"></p>
            </div>
        </div>

        <div class="mt-7 flex items-center gap-3">
            <button type="button" @click="accept()"
                    class="label-xs flex-1 rounded-lg bg-red-500/90 py-3.5 text-white transition-colors hover:bg-red-500">
                {{ __('admin.confirm.accept') }}
            </button>

            <button type="button" @click="cancel()"
                    class="label-xs rounded-lg border border-white/15 px-5 py-3.5 text-white/60 transition-colors hover:border-white/40 hover:text-white">
                {{ __('admin.cancel') }}
            </button>
        </div>
    </div>
</div>

@pushOnce("script")
<script>
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('confirmDialog', () => ({
            open: false,
            message: '',
            token: null,

            ask(detail) {
                this.message = detail.message
                this.token = detail.token
                this.open = true
            },

            accept() {
                window.dispatchEvent(new CustomEvent('confirm-accepted', { detail: { token: this.token } }))
                this.cancel()
            },

            cancel() {
                this.open = false
                this.token = null
            },
        }))
    })
</script>
@endPushOnce
