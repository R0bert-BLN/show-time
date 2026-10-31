# Show Time

Show Time is a festival ticketing web application built with Symfony 7.3. Visitors can browse and search festivals and artists, add ticket types to a cart, pay through Stripe Checkout, and receive a PDF containing QR-code tickets by email. Administrators manage festivals, bands, ticket types, issued tickets, payments, and staff from a separate admin panel.

## Tech stack

- PHP 8.2+
- Symfony 7.3
- Doctrine ORM
- MySQL

## Requirements

- XAMPP with PHP 8.2 or newer and MySQL
- Composer (XAMPP does not include it)
- PHP extensions: `ctype`, `iconv`, `intl`, `mbstring`, `pdo_mysql`, `openssl`, `zip`, `gd`, `fileinfo`, `curl`

Check the PHP version and extensions from the XAMPP shell:

```bash
php -v
php -m
```

If an extension is missing, enable it in `C:\xampp\php\php.ini` by removing the leading `;`, then restart Apache.

## Setup with XAMPP

### 1. Start XAMPP

Open the XAMPP Control Panel and start **Apache** and **MySQL**.

### 2. Put the project in `htdocs`

```text
C:\xampp\htdocs\show-time
```

All commands below are run from the project root:

```bash
cd C:\xampp\htdocs\show-time
```

```bash
C:\xampp\php\php.exe bin\console about
```

### 3. Create the database

Open `http://localhost/phpmyadmin` and run:

```sql
CREATE DATABASE show_time_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
```

### 4. Create `.env`

The repository does not include `.env`. Create it in the project root:

```dotenv
APP_ENV=dev
APP_SECRET=replace-with-a-random-string

DATABASE_URL="mysql://root:@127.0.0.1:3306/show_time_db?serverVersion=10.4.32-MariaDB&charset=utf8mb4"

MAILER_DSN=null://null
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0

STRIPE_PUBLIC_KEY=pk_test_your_public_key
STRIPE_SECRET_KEY=sk_test_your_secret_key
```

Notes:

- Generate `APP_SECRET` with `php -r "echo bin2hex(random_bytes(16));"`.
- XAMPP's MySQL `root` user has no password by default. If you set one, use `mysql://root:yourpassword@127.0.0.1:3306/...`.
- Replace `10.4.32-MariaDB` with the version shown by `SELECT VERSION();` in phpMyAdmin.
- Stripe keys are required for checkout. Use test keys from the Stripe dashboard.

### 5. Install PHP dependencies

Using XAMPP PHP and Composer:

```bash
C:\xampp\php\php.exe composer.phar install
```

### 6. Create the schema and demo data

```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --group=users --group=festivals
```

The fixtures create:

- Admin account: `johndoe@admin.com` / `password`
- 2 sample festivals and 5 sample bands
- No ticket types — create them in the admin panel before testing checkout

The fixture does not mark the admin as verified, and login requires a verified account. Run this once in phpMyAdmin:

```sql
UPDATE user SET is_verified = 1 WHERE email = 'johndoe@admin.com';
```

### 7. Build frontend assets

```bash
php bin/console tailwind:build
```

For development with automatic rebuilds:

```bash
php bin/console tailwind:build --watch
```

`public/build/alpine.js` is committed, so Node.js is not required just to run the app. If you change Alpine components under `assets/js`, rebuild it with:

```bash
npm install
npm run alpine
```

### 8. XAMPP PHP built-in server

Run Symfony with XAMPP's PHP:

```bash
C:\xampp\php\php.exe -S 127.0.0.1:8000 -t public
```

Then open `http://127.0.0.1:8000`.

## Useful commands

```bash
php bin/console cache:clear
php bin/console debug:router
php bin/console doctrine:migrations:status
php bin/console tailwind:build --watch
php bin/console messenger:consume async -vv
```
