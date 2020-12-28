# Release Notes

## [Unreleased](https://github.com/heroespatchnotes/sdk-php/compare/v0.9-beta.2...develop)

- `StringProvider` locale constants have been moved to a single array constant, `LOCALE`

## [v0.9-beta.2 (2020-12-26)](https://github.com/laravel/laravel/compare/v0.9-beta.1...v0.9-beta.2)

### Added
- `Entity::string(string $key)` New method for accessing Entity curated game strings ([](https://github.com/heroespatchnotes/sdk-php/commit/68b98422031f165afd2ba58cf1095ca2bf4a07ad))

### Removed

- **BC** Because of `Entity::string()` the `Skill` strings are no longer included in its `$contents` for magic access ([](https://github.com/heroespatchnotes/sdk-php/commit/68b98422031f165afd2ba58cf1095ca2bf4a07ad))
