# Peekora — cPanel Shared Hosting Deployment Guide

## Prerequisites

| Requirement | Minimum |
|---|---|
| PHP | 8.2+ (8.3 recommended) |
| MySQL | 5.7+ or MariaDB 10.4+ |
| PHP Extensions | BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML |
| Composer | 2.x |

---

## Step 1 — Prepare Your cPanel Hosting

1. Log into **cPanel > MySQL Databases**
2. Create a new database (e.g. `youraccount_peekora`)
3. Create a database user with a strong password
4. Assign the user **ALL PRIVILEGES** on that database
5. Note the database name, username, and password

---

## Step 2 — Upload the Application

### Option A — Upload as ZIP (easiest)

On your local machine, build production assets first:
```bash
npm run build
```
Then zip everything excluding `node_modules/` and `.git/`, and upload via **cPanel > File Manager** or FTP to your home directory `/home/youraccount/peekora`.

### Option B — SSH + Git (recommended for updates)

```bash
ssh youraccount@yourhost.com
cd ~
git clone https://github.com/yourrepo/peekora.git peekora
cd peekora
composer install --no-dev --optimize-autoloader
```

---

## Step 3 — Configure public_html Webroot (CRITICAL)

cPanel serves files from `public_html`. You need Laravel's `public/` folder to be the webroot.

### Method A — Symlink (if SSH is available)

```bash
mv ~/public_html ~/public_html_backup
ln -s ~/peekora/public ~/public_html
```

### Method B — Subdomain or Addon Domain

In cPanel > **Domains / Subdomains**, set the document root to `/home/youraccount/peekora/public`.

### Method C — Move public contents (if no SSH)

Copy the contents of `public/` into `public_html/` and edit `public_html/index.php`:

```php
// Change:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// To:
require __DIR__.'/../../peekora/vendor/autoload.php';
$app = require_once __DIR__.'/../../peekora/bootstrap/app.php';
```

---

## Step 4 — Configure Environment

```bash
cp .env.example .env
nano .env
```

Key values to update:

```dotenv
APP_NAME="Peekora"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=youraccount_peekora
DB_USERNAME=youraccount_dbuser
DB_PASSWORD=YourStrongPassword

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

APP_LOCALE=bn
```

---

## Step 5 — Install and Bootstrap

```bash
cd ~/peekora
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 6 — File Permissions

```bash
chmod -R 755 ~/peekora
chmod -R 775 ~/peekora/storage
chmod -R 775 ~/peekora/bootstrap/cache
```

---

## Step 7 — First Login

- **URL:** `https://yourdomain.com/login`
- **Email:** `admin@peekora.com`
- **Password:** `Admin@123!`

> Change the password immediately after first login via Admin > Users.

---

## Step 8 — Post-Deployment Checklist

- [ ] Change admin password
- [ ] Update Site Name and Tagline in Admin > Settings
- [ ] Add Google Analytics ID in Admin > Settings
- [ ] Add social media URLs in Admin > Settings
- [ ] Paste Adsterra codes in Admin > Ad Placements and activate slots
- [ ] Create your first article and job listing
- [ ] Verify sitemap at `https://yourdomain.com/sitemap.xml`
- [ ] Verify robots.txt at `https://yourdomain.com/robots.txt`
- [ ] Submit sitemap to Google Search Console

---

## Updating the Site

```bash
cd ~/peekora
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If you changed frontend CSS/JS, rebuild locally then re-upload `public/build/` via FTP.

---

## Troubleshooting

| Problem | Fix |
|---|---|
| 500 Error | Check `storage/logs/laravel.log` |
| Assets not loading | Re-run `npm run build`, re-upload `public/build/` |
| "Unable to locate file in Vite manifest" | Re-run `npm run build` |
| Images not showing | Run `php artisan storage:link` |
| Sessions not persisting | Set `SESSION_DRIVER=file` in `.env` |
| Permission errors | `chmod -R 775 storage bootstrap/cache` |
