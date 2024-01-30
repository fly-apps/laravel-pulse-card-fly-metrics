<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Requests"
    >
        <x-slot:icon>
            <x-pulse::icons.clock />
        </x-slot:icon>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
            <div class="grid gap-3 mx-px mb-px">
                <div>
                    <h3 class="font-bold text-gray-700 dark:text-gray-300">
                        Requests over Time
                    </h3>
                    @php
                        // todo: This
                        // $highest = $readings->flatten()->max();
                    @endphp

                    <div class="mt-3 relative">
                        {{--
                        <div class="absolute -left-px -top-2 max-w-fit h-4 flex items-center px-1 text-xs leading-none text-white font-bold bg-purple-500 rounded after:[--triangle-size:4px] after:border-l-purple-500 after:absolute after:right-[calc(-1*var(--triangle-size))] after:top-[calc(50%-var(--triangle-size))] after:border-t-[length:var(--triangle-size)] after:border-b-[length:var(--triangle-size)] after:border-l-[length:var(--triangle-size)] after:border-transparent">
                            Display a single numerical value here, perhaps a max 200 requests value
                        </div>
                        --}}
                        <div
                            wire:ignore
                            class="h-44"
                            x-data="{
                                init() {
                                    let chart = new Chart(
                                        this.$refs.canvas,
                                        {
                                            type: 'line',
                                            data: {
                                                labels: @js($httpMetrics['labels']),
                                                datasets: @js($httpMetrics['datasets']),
                                            },
                                            options: {
                                                maintainAspectRatio: false,
                                                layout: {
                                                    autoPadding: false,
                                                    padding: {
                                                        top: 1,
                                                    },
                                                },
                                                datasets: {
                                                    line: {
                                                        borderWidth: 2,
                                                        borderCapStyle: 'round',
                                                        pointHitRadius: 10,
                                                        pointStyle: false,
                                                        tension: 0.2,
                                                        spanGaps: false,
                                                        segment: {
                                                            borderColor: (ctx) => ctx.p0.raw === 0 && ctx.p1.raw === 0 ? 'transparent' : undefined,
                                                        }
                                                    }
                                                },
                                                scales: {
                                                    x: {
                                                        display: false,
                                                    },
                                                    y: {
                                                        beginAtZero: false,
                                                        display: false,
                                                    },
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: false,
                                                    },
                                                    tooltip: {
                                                        mode: 'index',
                                                        position: 'nearest',
                                                        intersect: false,
                                                    },
                                                },
                                            },
                                        }
                                    )
                                }
                            }"
                        >
                            <canvas x-ref="canvas" class="ring-1 ring-gray-900/5 dark:ring-gray-100/10 bg-gray-50 dark:bg-gray-800 rounded-md shadow-sm"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    </x-pulse::scroll>
</x-pulse::card>
