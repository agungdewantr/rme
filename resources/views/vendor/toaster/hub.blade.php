<div role="status" id="toaster" x-data="toasterHub(@js($toasts), @js($config))" @class([
    'tw-fixed tw-z-50 tw-p-4 tw-w-full tw-flex tw-flex-col tw-pointer-events-none tw-sm:p-6',
    'tw-bottom-0' => $alignment->is('bottom'),
    'tw-top-1/2 tw--translate-y-1/2' => $alignment->is('middle'),
    'tw-top-0' => $alignment->is('top'),
    'tw-items-start tw-rtl:items-end' => $position->is('left'),
    'tw-items-center' => $position->is('center'),
    'tw-items-end tw-rtl:items-start' => $position->is('right'),
])>
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.isVisible" x-init="$nextTick(() => toast.show($el))" @if ($alignment->is('bottom'))
            x-transition:enter-start="tw-translate-y-12 tw-opacity-0"
            x-transition:enter-end="tw-translate-y-0 tw-opacity-100"
        @elseif($alignment->is('top'))
            x-transition:enter-start="tw--translate-y-12 tw-opacity-0"
            x-transition:enter-end="tw-translate-y-0 tw-opacity-100"
        @else
            x-transition:enter-start="tw-opacity-0 tw-scale-90"
            x-transition:enter-end="tw-opacity-100 tw-scale-100"
            @endif
            x-transition:leave-end="tw-opacity-0 tw-scale-90"
            @class([
                'tw-relative tw-duration-300 tw-transform tw-transition tw-ease-in-out tw-max-w-xs tw-w-full tw-pointer-events-auto',
                'tw-text-center' => $position->is('center'),
            ])
            :class="toast.select({ error: 'tw-text-white', info: 'tw-text-black', success: 'tw-text-white',
                warning: 'tw-text-white' })"
            >
            <i x-text="toast.message"
                class="tw-inline-block tw-select-none tw-not-italic tw-px-6 tw-py-3 tw-rounded tw-shadow-lg tw-text-sm tw-w-full {{ $alignment->is('bottom') ? 'tw-mt-3' : 'tw-mb-3' }}"
                :class="toast.select({ error: 'tw-bg-red-500', info: 'tw-bg-gray-200', success: 'tw-bg-green-600',
                    warning: 'tw-bg-orange-500' })"></i>

            @if ($closeable)
                <button @click="toast.dispose()" aria-label="@lang('close')"
                    class="tw-absolute tw-right-0 tw-p-2 tw-focus:outline-none tw-rtl:right-auto tw-rtl:left-0 {{ $alignment->is('bottom') ? 'tw-top-3' : 'tw-top-0' }}">
                    <svg class="tw-h-4 tw-w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            @endif
        </div>
    </template>
</div>
