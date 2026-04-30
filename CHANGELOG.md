# Changelog

All notable changes to this package will be documented here.

## [2.1.0] - 2026-04-29

### Added
- `<x-lazycaptcha>` now accepts `colorScheme`, `watermarkPosition`, and `watermarkDisplay` props (kebab-case attribute forms also supported). These translate to the correct `data-*` attributes the widget JS reads.
- Three new package config keys with `LAZYCAPTCHA_COLOR_SCHEME`, `LAZYCAPTCHA_WATERMARK_POSITION`, and `LAZYCAPTCHA_WATERMARK_DISPLAY` env overrides.

### Changed
- Newsletter widgets are now pinned to `type="press_hold"` regardless of any other type the caller passes (server-side enforcement matches in `ChallengeManager`).
- Widget visual sizing is more compact across the board — standard 280px, compact 240px, login 260px, newsletter 220px. Min-heights collapse to content height instead of reserving fixed boxes.

### Fixed
- `color-scheme` and `watermark-*` attributes were previously dropped because the component never forwarded them as `data-*` — the JS therefore never saw them and always rendered with the default scheme. Now wired through correctly.
- `theme="auto"` and empty-string values on choice props no longer cause the normalizer to fall through to undefined behavior.

## [2.0.0] - 2026-04-28

### Changed
- Release-aligned package versioning for the LazyCaptcha 2.0 launch
- Documentation now reflects six challenge types and multi-step challenge flows

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
