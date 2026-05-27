# JSON Table Sharer

**#001** of [100 Microprojects Challenge](https://github.com/shiplite)

Paste JSON → see a beautiful HTML table → get a shareable link.

## Stack

- **Laravel 13** + PHP 8.3+
- **Livewire 4** (classic components)
- **Tailwind CSS 4**
- **SQLite** (zero-config database)
- **Vite** (asset bundling)

## Quick Start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

Start dev server:

```bash
composer run dev
```

Open http://localhost:8000

## How It Works

1. Paste a JSON array of objects (or a single object)
2. See a live table preview
3. Optionally add a title, click **Share Table**
4. Copy the generated link — anyone with the link sees a read-only table

## License

MIT
