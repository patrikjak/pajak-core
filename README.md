# pajak/core

A batteries-included admin foundation for Laravel — authentication, users, roles &
permissions, profile, settings, a dashboard, an admin shell and a module system — built on
[`pajak/ui`](https://packagist.org/packages/pajak/ui). Install it into a customer site and the
backend is ready on day one; you only add your frontend and custom modules.

> **Status:** early development (`v0.1.0` not yet tagged). The package skeleton and tooling are
> in place; features land per the phased plan.

## Requirements

- PHP `^8.5`
- Laravel `^13.0`

## Installation

```bash
composer require pajak/core
php artisan install:pajak-core     # publishes config + assets, removes the skeleton users migration (asks)
php artisan migrate                # roles + permissions are auto-synced
php artisan pajak-core:make-superadmin --email=you@example.com
```

Then visit `/admin/login`.

## Development

All commands run through Docker — see [`CLAUDE.md`](CLAUDE.md) for the full list.

```bash
docker compose run --rm cli composer install
docker compose run --rm node npm install && docker compose run --rm node npm run build
docker compose run --rm cli vendor/bin/phpcs --standard=ruleset.xml
docker compose run --rm cli php -d memory_limit=2G vendor/bin/phpstan analyse
docker compose run --rm test vendor/bin/phpunit     # MariaDB (only supported path)
```

## License

MIT © Patrik Jakab
