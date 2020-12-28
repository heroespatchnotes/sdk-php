<?php

declare(strict_types=1);

namespace Heroes\Factories;

use Heroes\Gamestring;
use Heroes\Providers\DataProvider;
use Heroes\Providers\StringProvider;
use IteratorAggregate;

/**
 * Base Factory
 *
 * Common methods for factories.
 */
abstract class BaseFactory implements IteratorAggregate
{
	/**
	 * Group to use for the Data Provider. Set by child.
	 *
	 * @var string
	 */
	protected $group;

	/**
	 * Path to the Entity's game Strings. Set by child.
	 *
	 * @var string
	 */
	protected $stringsPath;

	/**
	 * Keys to check for Entity game Strings. Set by child.
	 *
	 * @var string[]
	 */
	protected $stringsKeys;

	/**
	 * @var DataProvider
	 */
	protected $data;

	/**
	 * @var StringProvider
	 */
	protected $strings;

	/**
	 * Initializes the Providers
	 *
	 * @param string|null $locale Locale for game strings, null for "enus"
	 * @param string|null $patch  Patch to use, null for latest
	 */
	public function __construct(string $locale = null, string $patch = null)
	{
		$this->data    = DataProvider::get($this->group, $patch);
		$this->strings = StringProvider::get($locale ?? StringProvider::LOCALE['USA'], $patch);
	}

	/**
	 * Searches StringProvider for relevant Gamestrings
	 * to pass to the Entity.
	 *
	 * @param string $id Equivalent of Skill::id()
	 *
	 * @return array<string,Gamestring>
	 */
	protected function getStrings(string $id): array
	{
		// Harvest the relevant strings
		$path    = $this->stringsPath;
		$strings = [];
		foreach ($this->stringsKeys as $key)
		{
			if (isset($this->strings->gamestrings->$path->$key->$id))
			{
				$strings[$key] = new Gamestring($this->strings->gamestrings->$path->$key->$id);
			}
		}

		return $strings;
	}
}
