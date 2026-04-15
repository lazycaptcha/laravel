# Changelog

All notable changes to this package will be documented here.

## [0.1.0] - 2026-04-15

### Added
- Initial release
- `LazyCaptcha` client class with `verify()` and `check()` methods
- `LazyCaptchaServiceProvider` with auto-discovery
- `LazyCaptcha` facade
- `<x-lazycaptcha />` Blade component
- `@lazycaptcha` Blade directive
- `lazycaptcha` validation rule (string-based)
- `ValidLazyCaptcha` rule object with optional `minScore`
- `VerifyLazyCaptcha` middleware
- Configuration file with environment variable support
- Test suite using Orchestra Testbench
- GitHub Actions CI matrix across PHP 8.2-8.4 and Laravel 10-12
