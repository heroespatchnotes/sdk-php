# Heroes SDK
PHP SDK for Heroes of the Storm

[![](https://github.com/heroespatchnotes/sdk-php/workflows/PHPUnit/badge.svg)](https://github.com/heroespatchnotes/sdk-php/actions?query=workflow%3A%22PHPUnit)
[![](https://github.com/heroespatchnotes/sdk-php/workflows/PHPStan/badge.svg)](https://github.com/heroespatchnotes/sdk-php/actions?query=workflow%3A%22PHPStan)
[![Coverage Status](https://coveralls.io/repos/github/heroespatchnotes/sdk-php/badge.svg?branch=develop)](https://coveralls.io/github/heroespatchnotes/sdk-php?branch=develop)

## Installation

1. Add the `heroes-data` repository to your **composer.json**, e.g.:
```
	"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/heroespatchnotes/heroes-data"
		}
	],
```

2. Install with Composer: `> composer require heroespatchnotes/sdk`

## Description

`Heroes` is an SDK written in PHP to facilitate access to community resources for
Blizzard's MOBA, **Heroes of the Storm**.

## Game Data

Game data is extracted and maintained by [koliva8245](https://github.com/koliva8245)
and published under the **Heroes Tool Chest** at [heroes-data](https://github.com/HeroesToolChest/heroes-data).
The SDK offers convenient discovery and class wrapping for the raw JSON files on two
different levels: Providers and Entities.

### Providers

`Providers` locate and load the JSON-encoded data into convenience shared instances. You
can think of a `Provider` as the "database connection" for game data. Because they load
into entire files into memory the `Provider` can only be instantiated through its static
`get()` method to ensure a single, shared instance. `Providers` are file- and patch-specific
and come in two flavors. `Provider` contents may be accessed by their JSON keys or in their
entirety with the `getContent()` method.

#### DataProvider

A `DataProvider` accesses game data from the **data** subdirectories of a patch. Each
`DataProvider` requires a `$group` corresponding to the data file, and a `$patch` for the
version of data to use.

> Note: Omitting `$patch` will default to the latest available. You may always check a `Provider`'s patch by its `getPatch()` method.

Available groups are defined as class constants on the `DataProvider` class:
```
const ANNOUNCER         = 'announcer';
const BANNER            = 'banner';
const BEHAVIORVETERANCY = 'behaviorveterancy';
const EMOTICON          = 'emoticon';
const EMOTICONPACK      = 'emoticonpack';
const HERO              = 'hero';
const HEROSKIN          = 'heroskin';
const MATCHAWARD        = 'matchaward';
const MOUNT             = 'mount';
const PORTRAIT          = 'portrait';
const PORTRAITPACK      = 'portraitpack';
const REWARDPORTRAIT    = 'rewardportrait';
const SPRAY             = 'spray';
const UNIT              = 'unit';
const VOICELINE         = 'voiceline';
```

#### StringProvider

A `StringProvider` accesses game strings from the **gamestrings** subdirectories of a patch.
Each `StringProvider` requires a `$group` corresponding to the locale, and a `$patch` for the
version of data to use.

> Note: Omitting `$patch` will default to the latest available. You may always check a `Provider`'s patch by its `getPatch()` method.

Available groups are defined as class constants on the `StringProvider` class:
```
const LOCALE = [
	'Germany' => 'dede',
	'USA'     => 'enus',
	'Spain'   => 'eses',
	'Mexico'  => 'esmx',
	'France'  => 'frfr',
	'Italy'   => 'itit',
	'Korea'   => 'kokr',
	'Poland'  => 'plpl',
	'Brazil'  => 'ptbr',
	'Russia'  => 'ruru',
	'China'   => 'zhcn',
	'Taiwan'  => 'zhtw',
 ];
```

#### Examples
```
// Hero data, latest patch
$heroes = DataProvider::get('hero');
echo $heroes->Abathur->life->amount; // "685.0"

// Skin data from a previous patch
$skins = DataProvider::get('heroskin', '2.48.4.77406');
var_dump($skins->DemonHunterWinter);
array(
    "hyperlinkId": "WintersHelperValla",
    "attributeId": "Dhu5",
    "rarity": "Legendary",
    "releaseDate": "2017-12-12",
    "features": [
      "ThemedAbilities",
      "ThemedAnimations"
    ],
)

// English game strings, latest patch
$strings = StringProvider::get('enus');
echo $strings->gamestrings->unit->descriptino->Abathur; // "A unique Hero that can manipulate the battle from anywhere on the map."

// French game strings, previous patch
$older = StringProvider::get(StringProvider::FRANCE, '2.49.2.77981');
echo $older->gamestrings->abiltalent->$tassadarTalentId->name; // "Phase dimensionnelle"
// 
```

### Entities

`Entities` build on `Providers` to simplify access to common data components. Like `Providers`
`Entities` include access to the underlying JSON content, but they also have component-specific
methods for many endpoints.

`Entities` are created by using the corresponding `Factory`, which is patch- and locale-
specific:
```
// Tassadar, pre-rework, in French
$heroes   = new HeroFactory(StringProvider::LOCALE['France'], '2.49.2.77981');
$tassadar = $heroes->get('Tassadar');
foreach ($tassadar->abilities() as $ability)
{
	echo $ability->name; // e.g. "Phase dimensionnelle"
}
```

> Note: See the [API docs](docs/API.md) for details on each `Entity`.
