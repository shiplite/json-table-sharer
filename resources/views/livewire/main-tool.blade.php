<div>
    <h1 class="text-2xl font-bold mb-6">{{ config('app.name') }}</h1>
    <p class="text-zinc-600 dark:text-zinc-400 mb-8">Describe what this tool does in one sentence.</p>

    <div class="grid gap-6 lg:grid-cols-2">
        <div>
            <label for="input" class="block text-sm font-medium mb-2">Input</label>
            <textarea
                wire:model="input"
                id="input"
                rows="10"
                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-zinc-500"
                placeholder="Paste your data here..."
            ></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Output</label>
            <div class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 px-3 py-2 text-sm font-mono min-h-[240px] whitespace-pre-wrap">{{ $output }}</div>
        </div>
    </div>

    <button
        wire:click="process"
        class="mt-4 px-4 py-2 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 rounded-lg text-sm font-medium hover:bg-zinc-700 dark:hover:bg-zinc-300 transition-colors"
    >
        Process
    </button>
</div>
