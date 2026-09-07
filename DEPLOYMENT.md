# Scholar Metric — Deployment Guide

This guide documents the technology stack and the step-by-step production deployment process for the **Scholar Metric** academic evaluation platform (Laravel 13 monorepo with Vite/Tailwind front-end, MySQL, Apache, and Laravel Reverb for real-time updates).

---

## Table of Technologies / Development Stack

| Layer | Technology | Version | Purpose |
|---|---|---|---|
| Backend framework | Laravel | **13.3.x** (requires PHP `^8.3`) | Main application framework, routing, ORM, queues |
| Language | PHP | 8.3/8.4/8.5 (CLI + FPM) | Server-side runtime |
| Database | MySQL | 8.0+ (Amazon RDS Aurora MySQL compatible) | Primary relational data store |
| Web server | Apache | 2.4+ (`mpm` / FPM) | Serving the application + TLS |
| Frontend build | Vite | 8.x | Asset bundler/dev server |
| CSS framework | Tailwind CSS | 4.x (via `@tailwindcss/vite`) | Utility-first styling |
| Real-time/messaging | Laravel Reverb | 1.11.x | WebSocket broadcasting server (Pusher protocol) |
| Browser broadcast client | Laravel Echo + Pusher.js | 2.4.x / 8.6.x | Realtime notifications on the client |
| Charts | Chart.js | CDN (jsDelivr) | Dashboard/analytics charts |
| PDF generation | `barryvdh/laravel-dompdf` | 3.1.2 | Institutional / faculty PDF reports |
| Word export | `phpoffice/phpword` | 1.4.0 | Document generation |
| Mail | `symfony/mailtrap-mailer` | 8.1.0 | Transactional email transport |
| Testing | Pest + Pest Plugin Laravel | 4.4.x | Test suite (dev) |
| Static analysis | PHPStan | 2.2.x | Code quality (dev) |
| Package manager (PHP) | Composer | 2.x | PHP dependency manager |
| Package manager (JS) | npm | 11.x (Node 24) | Front-end dependency manager |
| Job queue default | Database driver | — | Async jobs processed by a worker |
| Cache/session default | Database driver | — | Session + cache storage |

---

## Steps to Deploy

### 1. Prerequisites / Server Requirements

Provision an Ubuntu/Debian (or RHEL-family) server and install the base packages:

```bash
sudo apt update && sudo apt -y upgrade
sudo apt install -y software-properties-common curl unzip git apache2 \
    mysql-client libapache2-mod-php \
    php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml \
    php8.3-bcmath php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-sqlite3 \
    supervisor
```

Install Composer and Node.js:

```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Node.js 20+ (24 LTS recommended)
curl -fsSL https://deb.nodesource.com/setup_24.x | sudo -E bash -
sudo apt install -y nodejs
```

> The app requires PHP `^8.3`. `dompdf`/`phpword` need `php-mbstring`, `php-xml`, and `php-gd` (or `imagick`). `php8.3-mysql` provides `pdo_mysql` which is required for the MySQL/RDS connection.

### 2. Clone the Repository

```bash
sudo mkdir -p /var/www
sudo git clone <repository-url> /var/www/scholar_metric
sudo chown -R "$USER":"$USER" /var/www/scholar_metric
cd /var/www/scholar_metric
```

### 3. Configure the Environment (`.env`)

Create the environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

Update the important values in `.env` (see Step 4 for the DB block):

```
APP_NAME="Scholar Metric"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_LEVEL=warning

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp            # smtp / mailtrap / ses
MAIL_HOST=smtp.yourprovider.com
MAIL_PORT=587
MAIL_USERNAME=your-user
MAIL_PASSWORD=your-pass
MAIL_FROM_ADDRESS="no-reply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

> The app keeps sessions, cache, and queue on the **database** driver by default, so the only external services required are MySQL (Step 4) and Reverb for WebSockets (Step 12).

### 4. Configure MySQL on Amazon RDS Aurora

Create an **Aurora MySQL** cluster (engine version **MySQL 8.0 compatible**) via RDS. When you create the database, use a dedicated user for the app (never the master user) with restrictive privileges on its own schema.

1. Create the database instance in the same VPC / security group as the EC2 web server.
2. Create the schema + app user:

```sql
CREATE DATABASE scholar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'scholar'@'%' IDENTIFIED BY 'replace-with-strong-password';
GRANT ALL PRIVILEGES ON scholar.* TO 'scholar'@'%';
FLUSH PRIVILEGES;
```

3. Allow the web server's security group to reach the RDS port (`3306`). For Aurora, ensure `rds.force_ssl` stays off **or** force TLS consistently — Laravel enables TLS automatically when `DB_SSLMODE` is set.

4. Fill in the DB block in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=<aurora-cluster-endpoint>.cluster-XXXXXXXX.us-east-1.rds.amazonaws.com
DB_PORT=3306
DB_DATABASE=scholar
DB_USERNAME=scholar
DB_PASSWORD='replace-with-strong-password'
# Enable explicit TLS to Aurora if enforced
# DB_SSLMODE=verify-ca
```

5. Test connectivity from the web server:

```bash
mysql -h <aurora-cluster-endpoint> -u scholar -p scholar -e "SELECT VERSION();"
```

### 5. Run Database Migrations

Install PHP dependencies first if not already done (`composer install --no-dev --optimize-autoloader`), then run the migrations:

```bash
cd /var/www/scholar_metric
php artisan migrate --force
```

> `--force` is required because the environment is `production`. The migrations create all tables including the session, cache, queue, and feedback/token tables.

### 6. Run the Database Seeder

The `DatabaseSeeder` runs `UniversitySeeder` (registrable universities) followed by `DemoSeeder` (a full demo: admin, 8 faculty, 32 students, courses, evaluations, feedback, tokens, and AI-moderation fixtures).

```bash
php artisan db:seed --force
```

The seeder emits a summary at the end; the demo credentials it creates are listed in the [Testing Credentials](#testing-credentials-from-the-seeder) section below.

> `DemoSeeder` is guarded: if it detects `nouman@pu.edu.pk` it **skips** duplicate seeding. To re-run from scratch: `php artisan migrate:fresh --seed --force`.

### 7. Install Frontend Dependencies

```bash
cd /var/www/scholar_metric
npm install                              # or: npm ci (lockfile-based, recommended for CI/CD)
npm run build                            # production asset build -> public/build
```

This compiles Tailwind 4 + the app's JS/Vite assets. `public/build` must exist before Apache serves the site.

> Do **not** run `npm run dev` in production — Vite's dev server is local-development only.

### 8. Create the Storage Link

Symlink `storage/app/public` into the public web root so uploaded avatars/media are reachable:

```bash
php artisan storage:link
```

### 9. Set Laravel Permissions

The web process (and the queue/scheduler workers) must be able to write to `storage/` and `bootstrap/cache/`:

```bash
sudo chown -R www-data:www-data /var/www/scholar_metric/storage /var/www/scholar_metric/bootstrap/cache
sudo chmod -R 775 /var/www/scholar_metric/storage /var/www/scholar_metric/bootstrap/cache
```

If your web user differs from `www-data`, adjust the owner accordingly. Ensure `.env` is not world-readable:

```bash
sudo chmod 600 /var/www/scholar_metric/.env
```

### 10. Configure Apache

Enable the required modules and `mod_rewrite`:

```bash
sudo a2enmod rewrite ssl headers proxy proxy_fcgi setenvif
sudo systemctl restart apache2
```

Create a virtual host — point `DocumentRoot` at `public/`:

```apache
# /etc/apache2/sites-available/scholar-metric.conf
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAdmin webmaster@your-domain.com

    DocumentRoot /var/www/scholar_metric/public

    <Directory /var/www/scholar_metric/public>
        Options -Indexes
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        # Optional: serve via PHP-FPM for better performance
        # SetHandler "proxy:unix:/run/php/php8.3-fpm.sock|fcgi://localhost"
    </FilesMatch>

    ErrorLog  ${APACHE_LOG_DIR}/scholar-metric-error.log
    CustomLog ${APACHE_LOG_DIR}/scholar-metric-access.log combined
</VirtualHost>
```

Enable the site and validate:

```bash
sudo a2ensite scholar-metric.conf
sudo systemctl reload apache2
apache2ctl -t
```

### 11. Configure Domain and HTTPS

1. Point the domain's **A/AAAA** records to the server.
2. Install and run Certbot for a free SSL certificate:

```bash
sudo apt install -y certbot python3-certbot-apache
sudo certbot --apache -d your-domain.com -d www.your-domain.com
```

3. Force HTTPS redirects in `.env`:

```
APP_URL=https://your-domain.com
```

4. (Optional) Add a global redirect inside the vhost so all HTTP traffic uses HTTPS:

```apache
# /etc/apache2/sites-available/scholar-metric-le-ssl.conf  (or main vhost)
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

5. Reload Apache: `sudo systemctl reload apache2`.

Certbot auto-renews; verify with `systemctl list-timers cron` / `certbot renew --dry-run`.

### 12. Configure Laravel Reverb

Reverb powers the real-time notifications broadcast (Laravel Echo + Pusher protocol).

1. Install Reverb (already in `composer.json` require-dev — in production run `composer install --no-dev` does **not** include it, so install without `--no-dev` if you need broadcasting):

```bash
composer require laravel/reverb
```

2. Publish config if the file is missing, then add env vars:

```bash
php artisan vendor:publish --tag=reverb-config
```

In `.env`:

```
BROADCAST_CONNECTION=reverb
BROADCAST_DRIVER=reverb

REVERB_APP_ID=scholar-metric
REVERB_APP_KEY=your-reverb-app-key
REVERB_APP_SECRET=your-reverb-app-secret
REVERB_HOST=0.0.0.0        # bind address
REVERB_PORT=8080
REVERB_SCHEME=http

# Client-facing WebSocket endpoint (behind HTTPS via Apache reverse proxy)
REVERB_SERVER_HOST=your-domain.com
REVERB_SERVER_PORT=8080
```

3. Expose the client-facing variables to the Vite build:

```
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_SERVER_HOST:-${REVERB_HOST}}"
VITE_REVERB_PORT="${REVERB_SERVER_PORT:-8080}"
VITE_REVERB_SCHEME="https"
```

Then recompile assets: `npm run build`.

4. Serve Reverb through Apache over WSS (recommended). Add a `ProxyPass` for `/apps` in your vhost:

```apache
<VirtualHost *:443>
    ServerName your-domain.com
    ...
    ProxyPreserveHost On
    RewriteEngine On
    RewriteCond %{HTTP:Upgrade} =websocket [NC]
    RewriteRule /apps/(.*) ws://127.0.0.1:8080/apps/$1 [P,L]
    ProxyPass /apps http://127.0.0.1:8080/apps/
    ProxyPassReverse /apps http://127.0.0.1:8080/apps/
</VirtualHost>
```

5. Start Reverb in the background (Supervisor config in Step 13 handles persistence):

```bash
php artisan reverb:start --host=0.0.0.0 --port=8080
```

### 13. Configure the Queue Worker

Jobs are stored on the `database` queue (`QUEUE_CONNECTION=database`). A long-running worker processes them. Run it via **Supervisor** so it survives reboots/restarts.

Create `/etc/supervisor/conf.d/scholar-metric-worker.conf`:

```ini
[program:scholar-metric-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/scholar_metric/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/scholar_metric/storage/logs/queue-worker.log
stopwaitsecs=3600
```

Pair it with a Reverb supervisor program (`scholar-metric-reverb.conf`) running `php artisan reverb:start`. Reload and start:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
sudo supervisorctl status
```

### 14. Configure the Scheduler (Cron)

The app schedules `evaluation:process-lifecycle` daily. Register Laravel's scheduler with cron:

```bash
crontab -e
# add:
* * * * * cd /var/www/scholar_metric && php artisan schedule:run >> /dev/null 2>&1
```

### 15. Clear and Optimize Laravel

With every deployment, run the optimization commands:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
php artisan event:cache
```

If anything misbehaves, reset and re-cache:

```bash
php artisan optimize:clear    # removes config/route/view/event/page caches
```

> Cache the config **after** setting all `.env` values, otherwise stale values are served.

### 16. Verify the Application

Functional smoke checks once Apache, Reverb, and the worker are up:

| Check | Expected |
|---|---|
| `curl -I https://your-domain.com` | `200 OK` |
| `/admin/dashboard` no debug stack | Renders in production (no `APP_DEBUG` output) |
| Login as a seeded user | Redirected to the role dashboard |
| `/admin/departments` | Department grid with performance bars |
| Generate a report (dashboard → Generate Report) | PDF downloads (dompdf) |
| Submit a demo feedback | Feedback recorded; realtime toast via Echo/Reverb |
| `php artisan queue:watch` / `logs/` | No repeated queue failures |
| `php artisan about` | Confirms environment, cache, and queue drivers |

---

## Testing Credentials (From the Seeder)

All seeded demo users share the password **`123456789`** (`DemoSeeder`).

| Role | Email | Notes |
|---|---|---|
| **Admin** | `nouman@pu.edu.pk` | Full access; registered to Punjab University |
| **Faculty** | `ahmed.khan@pu.edu.pk` | Computer Science department |
| **Student** | `ali.raza@pu.edu.pk` | CS student; unused feedback tokens available for the active evaluation |

Additional faculty accounts: `sara.ali@pu.edu.pk`, `usman.malik@pu.edu.pk`, `zara.tariq@pu.edu.pk`, `imran.qureshi@pu.edu.pk`, `nadia.jamil@pu.edu.pk`, `farhan.raza@pu.edu.pk`, `sana.munir@pu.edu.pk`.

> The `UniversitySeeder` only registers universities with domains `vu.edu.pk`, `pu.edu.pk`, and `uol.edu.pk` — a new admin's registration email domain must match one of these.

---

## Dependencies of the Tech Stack

### PHP / Composer Dependencies

Runtime (`composer.json` → `require`, resolved versions from `composer.lock`):

| Package | Version | Role |
|---|---|---|
| `php` | `^8.3` | Runtime |
| `laravel/framework` | `^13.0` (`13.3.0`) | Core framework |
| `barryvdh/laravel-dompdf` | `*` (`3.1.2`) | HTML → PDF reports |
| `phpoffice/phpword` | `^1.4` (`1.4.0`) | Word document generation |
| `symfony/mailtrap-mailer` | `*` (`8.1.0`) | Mailtrap SMTP transport |
| `laravel/mcp` | `^0.6.7` | MCP tooling |
| `laravel/tinker` | `^3.0` (`3.0.0`) | REPL/CLI interaction |

### Composer Development Dependencies

Dev-only (`composer.json` → `require-dev`):

| Package | Version | Role |
|---|---|---|
| `pestphp/pest` + `pestphp/pest-plugin-laravel` | `4.4.x` / `4.1.0` | Test framework |
| `fakerphp/faker` | `1.24.1` | Seed/test data generation |
| `laravel/boost` | `2.4.1` | Development/optimization helper |
| `laravel/pail` | `1.2.6` | Log tailing CLI |
| `laravel/pint` | `1.29.0` | Code style fixer |
| `laravel/reverb` | `1.11.0` | WebSocket broadcasting server |
| `laravel/sanctum` | `4.3.3` | API authentication |
| `mockery/mockery` | `1.6.12` | Mocking library |
| `nunomaduro/collision` | `8.9.3` | CLI error rendering |
| `phpstan/phpstan` | `2.2.5` | Static analysis |

> Note: in `composer.json`, `laravel/reverb` and `laravel/sanctum` are listed under `require-dev` — remember this when running `composer install --no-dev --optimize-autoloader` on production if you rely on broadcasting/API auth.

### JavaScript / npm Dependencies

From `package.json`:

| Package | Version | Role |
|---|---|---|
| `vite` | `^8.0.0` | Asset bundler/build tool |
| `@tailwindcss/vite` | `^4.0.0` | Tailwind 4 Vite plugin |
| `tailwindcss` | `^4.0.0` | CSS framework |
| `laravel-vite-plugin` | `^3.0.0` | Vite ↔ Laravel integration |
| `laravel-echo` | `^2.4.0` | Realtime broadcast client |
| `pusher-js` | `^8.6.0` | WebSocket client (Pusher protocol) |
| `axios` | `>=1.11.0 <=1.14.0` | HTTP client |
| `concurrently` | `^9.0.1` | Run dev processes together |
| `puppeteer` / `playwright` | `^24` / `^1.61` | Browser automation (screenshots/PDF tooling) |

Chart.js is loaded at runtime from the jsDelivr CDN (not bundled with npm).

### Server / Infrastructure Dependencies

| Component | Requirement | Notes |
|---|---|---|
| OS | Ubuntu/Debian (or RHEL-family) | 64-bit Linux recommended |
| Web server | Apache 2.4 | `mod_rewrite`, `mod_ssl`, `proxy`/`proxy_fcgi` for PHP-FPM & Reverb |
| PHP | 8.3+ | Extensions: `pdo`, `pdo_mysql`, `mbstring`, `xml`, `dom`, `gd`, `curl`, `zip`, `bcmath`, `intl`, `fileinfo`, `openssl`, `tokenizer`, `ctype`, `json` |
| Database | MySQL 8.0+ / Aurora MySQL (RDS) | `utf8mb4` schema; reachable on `3306` |
| Queue/cache/session | Database driver (default) | No Redis required unless `REDIS_*` configured |
| Process manager | Supervisor | Runs `queue:work` and `reverb:start` |
| Scheduler | cron | Runs `php artisan schedule:run` every minute |
| Node.js | 20 LTS+ (24 recommended) | Build-time only (`npm run build`) |
| TLS | Let's Encrypt (certbot) | Auto-renewing certs for HTTPS/WSS |
| Mail | SMTP server or Mailtrap | Account/institution mail for reports & notifications |

### Browser Dependencies

| Requirement | Notes |
|---|---|
| Modern evergreen browser | Latest Chrome, Firefox, Edge, or Safari |
| JavaScript enabled | Required (Vite assets, Echo, Chart.js) |
| WebSocket access | WSS to the Reverb endpoint (`/apps`) for realtime notifications |
| CDN access | Chart.js loads from jsDelivr — allowlist if a corporate proxy is used |
| Cookies (session) | Must accept the app's cookies (`SESSION_DRIVER=database`) |
| PDF viewer | Required to view generated report PDFs |