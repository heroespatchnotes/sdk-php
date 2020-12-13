# API Docs

## Locator Class

> Locates repository data dynamically from Composer's own directory structure.

### `static` getPath()

Locates the path to the Heroes Tool Chest organization in the vendor directory.

* **Parameters:** *none*
* **Returns:** The path
* **Return type:** `string`
* **Throws** `RuntimeException` If the directory cannot be found

Example:
```
echo Locator::getPath();
// "/var/www/html/vendor/heroestoolchest/"
```

### `static` getPatches()

Returns all discovered patch versions.

* **Parameters:** *none*
* **Returns:** An ordered array of patch versions (e.g. "2.47.2.76003", "2.48.0.76268_ptr")
* **Return type:** `string[]`

Example:
```
foreach (Locator::getPatches() as $patch)
{
	echo $patch . PHP_EOL;
}
```
Outputs:
```
2.47.2.76003
2.47.3.76124
2.48.0.76268_ptr
2.48.0.76389
2.48.1.76437
2.48.1.76517
2.48.2.76753
2.48.2.76781
2.48.2.76893
2.48.3.77205
2.48.4.77406
2.49.0.77435_ptr
2.49.0.77525
2.49.0.77548
2.49.1.77662
2.49.1.77692
2.49.2.77981
```

### `static` getLatest()

Returns the latest patch.

* **Parameters:** *none*
* **Returns:** Patch version of latest available data
* **Return type:** `string`

Example:
```
echo Locator::getLatest();
// "2.49.2.77981"
```

### `static` getPatchPath()

Returns the full path to the directory for a specific patch.

* **Parameters:** **$patch** `string` - The patch to locate
* **Returns:** Directory path
* **Return type:** `string`
* **Throws** `RuntimeException` If the directory cannot be found

Example:
```
echo Locator::getPatchPath('2.49.2.77981');
// "/var/www/html/vendor/heroestoolchest/heroes-data/heroesdata/2.49.2.77981"
```

### `static` shortPatch()

Gets the shorthand patch reference, e.g. "83086" from "2.53.0.83086".
Strips suffix "_ptr".

* **Parameters:** **$patch** `string` - The patch to shorten
* **Returns:** The patch shorthand
* **Return type:** `string`

Example:
```
echo Locator::shortPatch('2.49.2.77981');
// "77981"
```

## Provider Classes

> Loads, stores, and facilitates access to game content from udnerlying JSON files.

### `static` get()

Gets the shared instance of a Provider, used instead of creating the class directly.

* **Parameters:** **$group** `string` - The group to use, **Provider Groups** below for specifics
* **Parameters:** **$patch** `string` - The patch to use
* **Returns:** The shared instance of a particular provider
* **Return type:** `ProviderInterface`

Example:
```
$heroDataProvider = DataProvider::get('hero', '2.49.2.77981');
```

### getSource()

Returns the source file used by this Provider. Source files are automatically
de-duplicated, so if the Heroes Tool Chest patch indicates that a resource is
a duplicate of a previous patch then the correct file will be sourced automatically.

* **Parameters:** *none*
* **Returns:** Path to the JSON file
* **Return type:** `string`

Example:
```
echo $heroDataProvider->getSource();
// "/var/www/html/vendor/heroestoolchest/heroes-data/heroesdata/2.49.2.77981/data/herodata_77981_localized.json"
```

### getGroup()

Returns the group that was set when this Provider was created.

* **Parameters:** *none*
* **Returns:** The group
* **Return type:** `string`

Example:
```
echo $heroDataProvider->getGroup();
// "hero"
```

### getPatch()

Returns the patch that was set when this Provider was created.

* **Parameters:** *none*
* **Returns:** The group
* **Return type:** `string`

Example:
```
echo $heroDataProvider->getPatch();
// "2.49.2.77981"
```

### getMetaData()

Returns the metadata from the patch folder's **.hdp.json** file. This indicates which
version of Heroes Data Parser was used to create the files and if the version is a duplicate
in either data or gamestrings.

* **Parameters:** *none*
* **Returns:** The contents of **.hdp.json**
* **Return type:** `stdClass`

Example:
```
$metadata = $heroDataProvider->getMetaData();
echo 'Parsed by Heroes Data Parser version ' . $metadata->hdp;
// "Parsed by Heroes Data Parser version 4.5.2"
```

### getContents()

Returns the contents of the JSON source file.

* **Parameters:** *none*
* **Returns:** The decoded contents
* **Return type:** `stdClass`

Example:
```
echo $heroDataProvider->getContents()->Abathur->life->amount;
// "685.0";
```

## Provider Groups

> Used with `Provider::get(string $group)` to access specific sources.

### DataProvider
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

### StringProvider
```
const GERMANY = 'dede';
const USA     = 'enus';
const SPAIN   = 'eses';
const MEXICO  = 'esmx';
const FRANCE  = 'frfr';
const ITALY   = 'itit';
const KOREA   = 'kokr';
const POLAND  = 'plpl';
const BRAZIL  = 'ptbr';
const RUSSIA  = 'ruru';
const CHINA   = 'zhcn';
const TAIWAN  = 'zhtw';
```

## Factories

> Factories are used to produce Entities of a certain type. They are patch- and locale- specific.

### __construct()

Creates a new Factory.

* **Parameters:** **$locale** `string|null` The locale for the `StringProvider` (see above), defaults to "enus"
* **Parameters:** **$patch** `string|null` The patch version to use, defaults to the latest available
* **Returns:** A new Factory
* **Return type:** `BaseFactory`

Example:
```
$koreanHeroes = new HeroFactory(StringProvider::KOREA);
```

### getIterator()

Allows Factories to be iterated over (e.g. passed to `foreach`) to access all their members.

* **Parameters:** *none*
* **Returns:** Traversable
* **Return type:** `Traversable`

Example:
```
foreach ($heroes as $heroEntity)
{
	echo $heroEntity->name() . PHP_EOL;
}
```

## HeroFactory

> Creates `Hero` entities

### get()

Returns a Hero by its ID.

* **Parameters:** **$heroId** `string` The "hyperlinkId" Hero identifier
* **Returns:** A new `Hero` Entity with `Ability` and `Talent` Entities included
* **Return type:** `Hero`

Example:
```
$abathur = $heroFactory->get('Abathur');
foreach ($abathur->abilities() as $ability)
{
	...
}
```

## AbilityFactory & TalentFactory

> Creates skill entities for their respective types.


### hero()

Returns all Abilities/Talents for a Hero identified by its ID.

* **Parameters:** **$heroId** `string` The "hyperlinkId" Hero identifier
* **Returns:** An array of the Hero's Abilities or Talents
* **Return type:** `Ability[]` or `Talent[]`

Example:
```
foreach ($abilityFactory->hero('Chromie') as $talent)
{
	echo $ability->name() . PHP_EOL;
}
```

## Entities

*Entities are a work in progress so have limited documentation. See the [Entity Classes](src/Entities/) for more details.*

> `Entities` build on `Providers` to simplify access to common data components. Entities are usually created from their Factory.

### id()

Returns the unique identifier for the Entity.

* **Parameters:** *none*
* **Returns:** A unique ID that varies by each Entity
* **Return type:** `string`

Example:
```
echo $hero->id();
// "Abathur";
```
