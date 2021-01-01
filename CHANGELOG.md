# Release Notes

## [Unreleased](https://github.com/heroespatchnotes/sdk-php/compare/v0.9-beta.6...develop)

## [v0.9-beta.6 (2021-01-01)](https://github.com/heroespatchnotes/sdk-php/compare/v0.9-beta.5...v0.9-beta.6)

- Fixed a bug where `Factories` were not setting `null` strings on missing keys. ([](https://github.com/heroespatchnotes/sdk-php/pull/11/commits/3c93e991e4978bbf4b392c0b695be477a0a22780))

## [v0.9-beta.5 (2021-01-01)](https://github.com/heroespatchnotes/sdk-php/compare/v0.9-beta.4...v0.9-beta.5)

- Fixed a bug where the `HeroFactory` would fail to set a `Hero`'s contents, making game data unavailable for those entities. ([](https://github.com/heroespatchnotes/sdk-php/pull/10/commits/0feda27ef5f180ea72af21683a1b68559e516eca))

## [v0.9-beta.4 (2020-12-31)](https://github.com/heroespatchnotes/sdk-php/compare/v0.9-beta.3...v0.9-beta.4)

- Added `SkillFactory::getByNameId()` for easier `Ability` and `Talent` access. This includes Factory indexing under the hood. ([](https://github.com/heroespatchnotes/sdk-php/commit/dae06125057184519b08fd35124070a5ee74f62d))
- Added `Talent::abilities()` to get the name IDs for linked Abilities ([](https://github.com/heroespatchnotes/sdk-php/commit/ae87a9720885a3ee05526312b5dfee9f7d268111))

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
