# AGENTS.md

## Cursor Cloud specific instructions

### Overview

This is **SIPMEN (CKP ONLINE)** — a Laravel 5.7 PHP application for BPS (Statistics Indonesia) employee performance and office management. Single Laravel application (not a monorepo).

### System requirements

- **PHP 7.4** (via `ondrej/php` PPA; set as default with `update-alternatives --set php /usr/bin/php7.4`)
- **Node.js 10** (via nvm — required because `node-sass@4.11.0` only has prebuilt binaries for Node ≤ 12; Node 14+ requires Python 2 for compilation which is unavailable on Ubuntu 24.04)
- **MySQL 8.0** (installed via apt; requires manual start in container environments — see below)
- **Composer 2.x** (installed globally at `/usr/local/bin/composer`)

### Starting MySQL in the container

MySQL's systemd service does not work in this container environment. Start it manually:

```bash
sudo mkdir -p /var/run/mysqld && sudo chown mysql:mysql /var/run/mysqld
sudo mysqld --user=mysql --daemonize --pid-file=/var/run/mysqld/mysqld.pid --socket=/var/run/mysqld/mysqld.sock
sudo chmod 755 /var/run/mysqld
```

After starting, verify with: `mysql -u root -e "SELECT 1;"`

### Database

- Database name: `bps1600_sipmen`
- The SQL dump `bps1600_sipmen_lite_version.sql` in the repo root seeds the database (102 tables).
- One view creation at the end of the dump may error (`ERROR 1054 at line 50289`) — this is non-critical.

### Laravel setup

- No `.env.example` exists in the repo. Create `.env` manually with `APP_ENV=local`, `APP_DEBUG=true`, `DB_DATABASE=bps1600_sipmen`, `DB_USERNAME=root`, `DB_PASSWORD=` (empty).
- `storage/` directory is gitignored — create the full directory structure: `storage/app/public`, `storage/framework/{cache/data,sessions,views}`, `storage/logs`.
- `app/Http/Middleware/Authenticate.php` was in `.gitignore` but is required. It has been added to the repo.

### Key commands

| Action | Command |
|--------|---------|
| Install PHP deps | `composer install --no-interaction` |
| Install JS deps | `source ~/.nvm/nvm.sh && nvm use 10 && npm install` |
| Compile assets | `npm run dev` |
| Run dev server | `php artisan serve --host=0.0.0.0 --port=8000` |
| Run tests | `./vendor/bin/phpunit` |
| Generate app key | `php artisan key:generate` |

### Testing notes

- The Feature test (`tests/Feature/ExampleTest.php`) expects `GET /` to return 200, but the app redirects unauthenticated users (302). This is a pre-existing test issue, not a regression.
- PHPUnit config is in `phpunit.xml`; test env uses array drivers for cache/session/mail.

### Test login credentials

- Email: `admin@email.com`, Password: `password` (set via bcrypt hash update on the admin user)
- Admin has `superadmin` role with `kdprop=16`, `kdkab=00` (Provinsi Sumatera Selatan)
