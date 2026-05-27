# microapp-template

Starter template for shipping micro-tools fast.

## Stack

- **Laravel 13** + PHP 8.3+
- **Livewire 4** (classic components)
- **Tailwind CSS 4**
- **SQLite** (zero-config database)
- **Vite** (asset bundling)

## Quick Start

1. Click **"Use this template"** on GitHub
2. Clone your new repo
3. Run setup:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

4. Start developing:

```bash
composer run dev
```

5. Edit your tool:
   - `app/Livewire/MainTool.php` — logic
   - `resources/views/livewire/main-tool.blade.php` — template

## Structure

```
app/Livewire/MainTool.php                     ← component logic
resources/views/
├── components/layouts/app.blade.php          ← base layout
└── livewire/main-tool.blade.php              ← component template
routes/web.php                                ← single route
```

## Deploy

Build assets before deploying:

```bash
npm run build
```

## License

MIT
