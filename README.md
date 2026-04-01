# Slim Portal

**Slim's Fashion & Arts School** — Laravel CMS portal for educational institutions.

## Stack
- Laravel 13 (PHP 8.x) + MySQL
- Role-based admin panel (Admin + Staff)
- Standalone SCORM course builder (Claude API)
- Moodle-compatible deployment

## Quick Start

```bash
composer install
npm install && npm run build
cp .env.example .env && php artisan key:generate
# Edit .env: set DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

**Default admin:** `admin@slimsfashion.com` / `Admin@1234!` — change immediately.

Admin panel: `/admin` | SCORM tool: `/scorm-tool/`

## Deploy to a New Institution
All branding is DB-driven — update via Admin → Page Content. No code changes needed per client.
