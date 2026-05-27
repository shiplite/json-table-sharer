<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold">{{ $sharedTable->title ?: 'Shared Table' }}</h1>
        <p class="text-sm text-zinc-500 mt-1">Created {{ $sharedTable->created_at->diffForHumans() }} · {{ count($sharedTable->json_data) }} {{ count($sharedTable->json_data) === 1 ? 'row' : 'rows' }} · Expires {{ $sharedTable->expires_at->diffForHumans() }}</p>
    </div>

    @if (!empty($columns) && !empty($sharedTable->json_data))
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
                    @foreach ($sharedTable->json_data as $row)
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
    @endif

    <div class="mt-6 flex items-center gap-4">
        <a
            href="/"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors"
        >
            ← Create your own table
        </a>
        <button
            x-data
            x-on:click="navigator.clipboard.writeText(window.location.href); $el.textContent = 'Copied!'; setTimeout(() => $el.textContent = 'Copy link', 1500)"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors"
        >
            Copy link
        </button>
    </div>
</div>
