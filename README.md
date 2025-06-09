# Referral Program for Freestays.eu

This repository contains a simple referral system designed for a Laravel application such as [BookingCore](https://bookingcore.com/). It provides basic features similar to the early Dropbox and Gmail invite programs.

## Features

- Generate unique referral codes for users
- Track signups made through referral codes
- Query how many referrals a user has

## Installation

1. Include this repository in your Laravel project and run composer install:

```bash
composer install
```

2. Run the migration to create the referral tables:

```bash
php artisan migrate --path=database/migrations/2024_01_01_000000_create_referral_tables.php
```

3. Load the routes in your `routes/web.php` or `routes/api.php`:

```php
require base_path('routes/referral.php');
```

4. Inject `Freestays\Referral\ReferralService` where needed or use the provided controller.

## Usage

- POST `/referral/generate` to generate a code for the authenticated user.
- POST `/referral/register` with a `code` parameter when a new user signs up using a referral.

## License

This project is released under the MIT License.
