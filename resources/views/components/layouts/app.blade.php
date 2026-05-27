<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="{{ $description ?? '' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased">
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="font-semibold text-lg">{{ config('app.name') }}</a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 mt-auto">
        <div class="max-w-4xl mx-auto px-4 py-4 text-sm text-zinc-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </footer>
</body>
</html>
