<div>
    <h1 class="text-2xl font-bold mb-2">{{ config('app.name') }}</h1>
    <p class="text-zinc-600 dark:text-zinc-400 mb-6">Paste JSON → see a table → share a link.</p>

    {{-- Input section --}}
    <div class="space-y-3">
        <label for="json-input" class="block text-sm font-medium">Paste your JSON</label>
        <textarea
            wire:model.live.debounce.1000ms="jsonInput"
            id="json-input"
            rows="8"
            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-zinc-500 placeholder:text-zinc-400"
            placeholder='[{"name": "Alice", "age": 30}, {"name": "Bob", "age": 25}]'
        ></textarea>
    </div>

    {{-- Error --}}
    @if ($error)
        <div class="mt-4 px-4 py-3 bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-700 dark:text-red-300">
            {{ $error }}
        </div>
    @endif

    {{-- Table preview --}}
    @if ($parsedData && $columns)
        <div class="mt-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-semibold">Preview</h2>
                <span class="text-sm text-zinc-500">{{ count($parsedData) }} {{ count($parsedData) === 1 ? 'row' : 'rows' }}</span>
            </div>
            <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-zinc-100 dark:bg-zinc-800">
                            @foreach ($columns as $col)
                                <th class="px-4 py-2.5 text-left font-semibold text-zinc-700 dark:text-zinc-300 whitespace-nowrap">{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach ($parsedData as $row)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900/50">
                                @foreach ($columns as $col)
                                    <td class="px-4 py-2 max-w-xs truncate text-zinc-800 dark:text-zinc-200">
                                        @if (is_array($row[$col] ?? null))
                                            <code class="text-xs bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">{{ json_encode($row[$col]) }}</code>
                                        @else
                                            {{ $row[$col] ?? '' }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Share controls --}}
            <div class="mt-4 flex flex-col sm:flex-row gap-3 items-start sm:items-end">
                <div class="flex-1 w-full sm:w-auto">
                    <label for="title" class="block text-sm font-medium mb-1">Title <span class="text-zinc-400">(optional)</span></label>
                    <input
                        wire:model="title"
                        id="title"
                        type="text"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500"
                        placeholder="My dataset"
                    >
                </div>
                <button
                    wire:click="share"
                    wire:loading.attr="disabled"
                    class="px-5 py-2 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 rounded-lg text-sm font-medium hover:bg-zinc-700 dark:hover:bg-zinc-300 transition-colors shrink-0 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="share">Share Table</span>
                    <span wire:loading wire:target="share">Sharing…</span>
                </button>
                <button
                    wire:click="clear"
                    class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-medium hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors shrink-0"
                >
                    Clear
                </button>
            </div>

            {{-- Share URL --}}
            @if ($shareUrl)
                <div class="mt-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                    <span class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">Shared!</span>
                    <input
                        type="text"
                        readonly
                        value="{{ $shareUrl }}"
                        class="flex-1 text-sm bg-transparent border-none outline-none text-emerald-800 dark:text-emerald-200 font-mono"
                        x-on:click="$el.select()"
                    >
                    <button
                        x-data
                        x-on:click="navigator.clipboard.writeText(@js($shareUrl)); $el.textContent = 'Copied!'; setTimeout(() => $el.textContent = 'Copy', 1500)"
                        class="text-sm font-medium text-emerald-700 dark:text-emerald-300 hover:text-emerald-900 dark:hover:text-emerald-100"
                    >Copy</button>
                </div>
            @endif
        </div>
    @endif
</div>
