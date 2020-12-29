# Release Notes

## [Unreleased](https://github.com/heroespatchnotes/sdk-php/compare/v0.9-beta.3...develop)

## [v0.9-beta.3 (2020-12-29)](https://github.com/heroespatchnotes/sdk-php/compare/v0.9-beta.2...v0.9-beta.3)

- `Gamestring` class added to add formatting for all `StringProvider` output on Entities ([](https://github.com/heroespatchnotes/sdk-php/commit/81be7586062d6a9003e660e22868859a9ae2a007))
- `StringProvider` locale constants have been moved to a single array constant, `LOCALE` ([](https://github.com/heroespatchnotes/sdk-php/commit/59163d246b217adb29796db5036c7db522025cf8))
- `BaseEntity::string()` now returns the new `Gamestring` type (still `string` compatible) ([](https://github.com/heroespatchnotes/sdk-php/commit/3b5764303a78521f7999faadce4ad56863f7a29c))
- `BaseEntity::string()` now throws a `RuntimeException` if the key does not exist ([](https://github.com/heroespatchnotes/sdk-php/commit/32e8f36a4d5ab71dfc935477f8d7755329fa9d78))
- `BaseFactory::getStrings()` now detects any relevant strings in a `Factory`'s  subGroup; thus `BaseFactory::$stringsKeys` is also removed ([](https://github.com/heroespatchnotes/sdk-php/commit/116e164884a26488911ccb4f01fc76bb4e3cf23d))

## [v0.9-beta.2 (2020-12-26)](https://github.com/laravel/laravel/compare/v0.9-beta.1...v0.9-beta.2)

### Added
- `BaseEntity::string(string $key)` New method for accessing Entity curated game strings ([](https://github.com/heroespatchnotes/sdk-php/commit/68b98422031f165afd2ba58cf1095ca2bf4a07ad))

### Removed

- **BC** Because of `BaseEntity::string()` the `Skill` strings are no longer included in its `$contents` for magic access ([](https://github.com/heroespatchnotes/sdk-php/commit/68b98422031f165afd2ba58cf1095ca2bf4a07ad))
