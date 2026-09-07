# ScholarMetric

A multi-tenant university **faculty evaluation / student feedback** system built with Laravel 13. It lets universities manage evaluations, lets students submit (moderated, anonymous) feedback, and gives faculty dashboards with ratings, trends, written comments, and PDF reports.

---

## Table of Contents

- [Requirements](#requirements)
- [Installation (Local Setup)](#installation-local-setup)
- [Environment Configuration (.env)](#environment-configuration-env)
- [Database Migrations & Seeding](#database-migrations--seeding)
- [Running the Application](#running-the-application)
- [Default Demo Credentials](#default-demo-credentials)
- [University Admin Seeding (UniversitySeeder)](#university-admin-seeding-universityseeder)
- [Seeding a New University Admin](#seeding-a-new-university-admin)
- [Moderation (Gemini AI)](#moderation-gemini-ai)
- [Common Commands / Troubleshooting](#common-commands--troubleshooting)

---

## Requirements

- **PHP** >= 8.3 (with extensions: `pdo_mysql`, `mbstring`, `xml`, `curl`, `gd`, `zip`, `intl`)
- **Composer** (latest)
- **Node.js** >= 20 and **npm** (for the Vite build / Tailwind assets)
- A **MySQL** (or MariaDB) server — the app is written against MySQL. SQLite may be used for quick smoke tests but MySQL is recommended.
- (Optional) a **Gemini API key** for AI moderation of written comments — see [Moderation (Gemini AI)](#moderation-gemini-ai).

> Verify your environment: `php -v && composer --version && node -v && npm -v`

---

## Installation (Local Setup)

Clone the repository and install dependencies:

```bash
# 1. Clone the project
git clone <your-repo-url> scholar_metric
cd scholar_metric

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies
npm install

# 4. Create the .env file from the example (copies .env.example -> .env)
cp .env.example .env
```

---

## Environment Configuration (.env)

Open `.env` and configure your database connection. The easiest route is MySQL:

```dotenv
APP_NAME=ScholarMetric
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# --- Database (MySQL) ---
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scholar
DB_USERNAME=root
DB_PASSWORD=

# --- Session / Queue / Cache ---
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
BROADCAST_CONNECTION=log
```

Then generate the application key:

```bash
# Generate APP_KEY (required!)
php artisan key:generate

# Create the storage symlink (required for avatars/uploads)
php artisan storage:link
```

> Note: `SESSION_DRIVER`, `QUEUE_CONNECTION` and `CACHE_STORE` are set to `database` by default, which requires the framework tables to exist (created by `php artisan migrate` below). You may also use `file` / `sync` for local development if you prefer.

---

## Database Migrations & Seeding

Create the database first (or from your MySQL client):

```sql
CREATE DATABASE scholar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then run the migrations:

```bash
php artisan migrate
```

> If you change anything later and want a clean slate, use:
> `php artisan migrate:fresh` (this wipes all data — use with care).

### Optional: Seed for full demo experience

Run the base seeder, which calls `UniversitySeeder` then `DemoSeeder`:

```bash
php artisan db:seed
```

Or seed only the universities:

```bash
php artisan db:seed --class=UniversitySeeder
```

To start totally fresh with seed data in one shot:

```bash
php artisan migrate:fresh --seed
```

See [University Admin Seeding (UniversitySeeder)](#university-admin-seeding-universityseeder) for details on the seeded universities and demo credentials.

---

## Running the Application

Run the local dev server and the Vite asset bundler in **two terminals**:

**Terminal 1 — Laravel server:**
```bash
php artisan serve
# -> http://localhost:8000
```

**Terminal 2 — Vite (frontend assets / Tailwind):**
```bash
npm run dev
```

Open **http://localhost:8000** in your browser.

> For production-like assets instead of the Vite dev server, run `npm run build` once and serve normally.

---

## Default Demo Credentials

After running `php artisan db:seed` (DemoSeeder), the following accounts are created with the shared password:

| Role    | Email                  | Password   |
|---------|------------------------|------------|
| Admin   | `nouman@pu.edu.pk`     | `123456789`|
| Faculty | `ahmed.khan@pu.edu.pk` | `123456789`|
| Student | `ali.raza@pu.edu.pk`   | `123456789`|

Demo data (created by `DemoSeeder`) includes 8 faculty members, 32 students, courses, evaluations, feedback tokens, and ~700 feedback responses with moderation statuses so every dashboard/report is fully populated.

---

## University Admin Seeding (UniversitySeeder)

`Database\Seeders\UniversitySeeder` populates the `universities` table with the institutions whose email domains are **eligible for admin self-registration**.

```php
// database/seeders/UniversitySeeder.php
$universities = [
    ['name' => 'Virtual University of Pakistan', 'domain' => 'vu.edu.pk'],
    ['name' => 'Punjab University',              'domain' => 'pu.edu.pk'],
    ['name' => 'University of Lahore',           'domain' => 'uol.edu.pk'],
];
```

- An admin registers with an email whose domain matches one of these — e.g. `nouman@pu.edu.pk`.
- Adds **only the universities that don't already exist** (`firstOrCreate` keyed on `domain`), so it is safe to run repeatedly.

Run it with:

```bash
php artisan db:seed --class=UniversitySeeder
```

---

## Seeding a New University Admin

To create an **admin belonging to a specific university**, add that university to `UniversitySeeder` (if missing) and then create the admin user. You can do this in a tinker session:

```bash
php artisan tinker
```

```php
use App\Models\University;
use App\Models\User;
use App\Enums\Role;
use Illuminate\Support\Facades\Hash;

// 1. Make sure the university exists (or create it)
$uni = University::firstOrCreate(
    ['domain' => 'example.edu.pk'],
    ['name' => 'Example University']
);

// 2. Create the admin for that university
User::create([
    'name'                => 'University Admin',
    'email'               => 'admin@example.edu.pk',
    'password'            => Hash::make('123456789'),
    'role'                => Role::Admin,
    'admin_id'            => 'ADM-UNI01',
    'access_level'        => 'Full Access',
    'email_verified_at'   => now(),
    'is_active'           => true,
    'university_id'       => $uni->id,
]);
```

Or, if you prefer, add it to `DemoSeeder`/`UniversitySeeder` under the `App\Enums\Role` enum and re-run `php artisan migrate:fresh --seed`.

> **Note:** admins are scoped to their `university_id` (multi-tenant). A university admin only sees users, courses, evaluations, feedback, and reports belonging to their own university.

---

## Moderation (Gemini AI)

Written feedback (`what_worked_well`, `what_could_improve`, `comments`) is moderated before saving. If the **Gemini API key** is configured, Google Gemini handles it; otherwise the code falls back to a **local keyword filter** (`GeminiModerationService::localModerate`).

Add these to your `.env` (optional but recommended):

```dotenv
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-3.5-flash
```

Moderation statuses saved on each answer: `approved`, `flagged`, or `rejected`. Only approved comments are shown on faculty dashboards / reports.

---

## Common Commands / Troubleshooting

| Task | Command |
|------|---------|
| Install PHP deps | `composer install` |
| Install JS deps | `npm install` |
| Generate app key | `php artisan key:generate` |
| Run migrations | `php artisan migrate` |
| Reset all data + seed | `php artisan migrate:fresh --seed` |
| Seed universities only | `php artisan db:seed --class=UniversitySeeder` |
| Storage symlink | `php artisan storage:link` |
| Start server | `php artisan serve` |
| Start Vite dev | `npm run dev` |
| Build assets | `npm run build` |
| Run tests | `php artisan test` |
| Laravel Pint (code style) | `./vendor/bin/pint` |
| Queue worker (if QUEUE_CONNECTION=database) | `php artisan queue:work` |

### Common issues

- **`APP_KEY` is empty** → run `php artisan key:generate`.
- **Session table not found** → run `php artisan migrate` (session driver is `database`).
- **404 on `/faculty/...` etc.** → make sure `APP_URL` is correct and the routes are cached-free (`php artisan route:clear`).
- **Assets not loading / unstyled page** → start `npm run dev` or run `npm run build`.
- **Storage images broken** → run `php artisan storage:link`.
