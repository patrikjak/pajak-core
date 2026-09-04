# CLAUDE.md — pajak/core

`pajak/core` is an admin foundation for Laravel (auth, users, roles/permissions, profile,
settings, dashboard, module system), built on `pajak/ui` and installed into customer sites via
Composer. A sibling `core-demo` app exercises it end to end.

## Commands

All via Docker. Tests run against **MariaDB only** through the `test` service (the `cli` service
has no database).

```bash
docker compose run --rm test vendor/bin/phpunit
docker compose run --rm cli vendor/bin/phpcs --standard=ruleset.xml
docker compose run --rm cli vendor/bin/phpcbf --standard=ruleset.xml
docker compose run --rm cli php -d memory_limit=2G vendor/bin/phpstan analyse
docker compose run --rm node npm run build       # -> public/assets/core.{css,js}, committed
docker compose run --rm node npm run typecheck
docker compose run --rm node npm run dev
```

`public/assets/` is committed so consumers need no build step — rebuild and commit after any
CSS/TS change. `core.scss` pulls `pajak/ui` tokens via a `/pajak-ui/` prefix resolved by the Sass
importer in `vite.config.js`.

## Conventions

Follow the workspace PHP coding standards. Core-specific exception: `Models\{User,Role,Permission,
Invitation,Setting}` and the abstract `Module` are **not** `final` — consumers extend them.
Namespace `Pajak\Core`, config key `pajak-core`, provider `Pajak\Core\CoreServiceProvider`
(auto-discovered). PHPStan runs at level 8 over `src`/`config`/`database`; `tests/` is not analysed.
