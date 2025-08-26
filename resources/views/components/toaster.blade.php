<div x-data="toasterManager({
    duration: {{ $duration }},
    maxToasts: {{ $maxToasts }},
    stackable: {{ $stackable ? 'true' : 'false' }},
    showProgress: {{ $showProgress ? 'true' : 'false' }}
})" x-init="init()" @toast.window="addToast($event.detail)"
    class="fixed z-50 {{ $getPositionClasses() }}">
    <div class="space-y-3 max-w-xs w-full">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="pointer-events-auto {{ $getThemeClasses()['container'] }}"
                role="alert">
                <div class="flex p-4">
                    <div class="shrink-0" x-html="getToastIcon(toast.type)"></div>
                    <div class="ms-3 flex-1">
                        <p class="{{ $getThemeClasses()['text'] }}" x-html="toast.message"></p>
                    </div>
                    <div class="ms-2">
                        <button @click="removeToast(toast.id)"
                            class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 dark:text-white">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m18 6-12 12"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-show="toast.showProgress"
                    class="h-1 bg-gray-200 dark:bg-neutral-700 overflow-hidden rounded-b-xl">
                    <div class="h-full transition-all duration-100 ease-linear rounded-b-xl"
                        :class="getProgressColor(toast.type)" :style="`width: ${toast.progress}%`"></div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    function toasterManager(config = {}) {
        return {
            toasts: [],
            nextId: 1,
            config: {
                duration: 5000,
                maxToasts: 5,
                stackable: true,
                showProgress: false,
                ...config
            },

            init() {},

            addToast(options) {
                const toast = {
                    id: this.nextId++,
                    type: options.type || 'info',
                    message: options.message,
                    duration: options.duration ?? this.config.duration,
                    visible: false,
                    progress: 100,
                    showProgress: options.showProgress ?? this.config.showProgress,
                    timer: null,
                    progressTimer: null
                };

                if (this.config.stackable && this.toasts.length >= this.config.maxToasts) {
                    this.removeOldestToast();
                }

                this.toasts.push(toast);
                setTimeout(() => {
                    this.toasts = this.toasts.map(t => t.id === toast.id ? {
                        ...t,
                        visible: true
                    } : t);

                    this.startTimer(toast);
                }, 100);
            },

            removeToast(id) {
                const toast = this.toasts.find(t => t.id === id);
                if (toast) {
                    if (toast.timer) clearTimeout(toast.timer);
                    if (toast.progressTimer) clearInterval(toast.progressTimer);
                    toast.visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                }
            },

            removeOldestToast() {
                if (this.toasts.length > 0) {
                    this.removeToast(this.toasts[0].id);
                }
            },

            startTimer(toast) {
                if (toast.duration <= 0) return;

                if (toast.showProgress) {
                    const progressStep = 100 / (toast.duration / 100);
                    toast.progressTimer = setInterval(() => {
                        toast.progress -= progressStep;
                        if (toast.progress <= 0) {
                            clearInterval(toast.progressTimer);
                        }
                    }, 100);
                }

                toast.timer = setTimeout(() => {
                    this.removeToast(toast.id);
                }, toast.duration);
            },

            getToastIcon(type) {
                const icons = {
                    success: `<svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path></svg>`,
                    error: `<svg class="shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path></svg>`,
                    warning: `<svg class="shrink-0 size-4 text-yellow-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path></svg>`,
                    info: `<svg class="shrink-0 size-4 text-blue-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m9.708 6.075-3.024.379-.108.502.595.108c.387.093.464.232.38.619l-.975 4.577c-.255 1.183.14 1.74 1.067 1.74.72 0 1.554-.332 1.933-.789l.116-.549c-.263.232-.65.325-.905.325-.363 0-.494-.255-.402-.704l1.323-6.208zM9.537 2.21a1.13 1.13 0 1 0-2.26 0 1.13 1.13 0 0 0 2.26 0z"></path></svg>`
                };
                return icons[type] || icons.info;
            },

            getProgressColor(type) {
                const colors = {
                    success: 'bg-teal-500',
                    error: 'bg-red-500',
                    warning: 'bg-yellow-500',
                    info: 'bg-blue-500'
                };
                return colors[type] || colors.info;
            }
        };
    }
</script>
