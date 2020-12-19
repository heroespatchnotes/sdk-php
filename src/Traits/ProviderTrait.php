<?php

declare(strict_types=1);

namespace Heroes\Traits;

use Heroes\Locator;
use JsonException;
use RuntimeException;

/**
 * Provider Trait
 *
 * Static constructor to return an instance
 * of the child Provider.
 */
trait ProviderTrait
{
	/**
	 * Returns a new/shared instance.
	 *
	 * @param string $group      The group
	 * @param string|null $patch The patch version, or null to use latest
	 *
	 * @return self
	 */
	public static function get(string $group, string $patch = null): self
	{
		$patch = $patch ?? Locator::getLatest();
		$hash  = $group . '_' . $patch;

		if (! isset(static::$instances[$hash]))
		{
			static::$instances[$hash] = new static($group, $patch);
		}

		return static::$instances[$hash];
	}

	//--------------------------------------------------------------------
	
	/**
	 * Stores the group and patch and loads the contents.
	 *
	 * @param string $group The group
	 * @param string $patch The patch version
	 *
	 * @throws RuntimeException For missing file
	 * @throws JsonException    For invalid file
	 */
	private function __construct(string $group, string $patch)
	{
		$this->setPatch($patch ?? Locator::getLatest());
		$this->group = $group;

		$this->contents = json_decode(file_get_contents($this->getSource()), false, JSON_THROW_ON_ERROR);
	}
}
