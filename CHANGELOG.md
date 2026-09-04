# Changelog

All notable changes to `pajak/core` are documented here. The format is based on
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Package skeleton and tooling: Composer/npm/Vite/PHPUnit/PHPStan/PHPCS config, Docker Compose
  (`cli`, `node`, `test-db`, `test`), CI via `patrikjak/workflows` (lint + MariaDB test job),
  empty `CoreServiceProvider`, Testbench `TestCase`, placeholder `core.scss` / `core.ts`. Tests
  run against MariaDB only.
