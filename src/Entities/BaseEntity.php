<?php

declare(strict_types=1);

namespace Heroes\Entities;

use Heroes\Gamestring;
use RuntimeException;

/**
 * Base Entity
 */
abstract class BaseEntity
{
	use \Heroes\Traits\GetterTrait;

	/**
	 * @var string|null
	 */
	protected $id;

	/**
	 * Array of selected game Strings
	 *
	 * @var array<string,Gamestring>
	 */
	protected $strings;

	/**
	 * Returns the Entity ID.
	 *
	 * @return string
	 */
	public function id(): string
	{
		return $this->id;
	}

	/**
	 * Returns a Gamestring by its name.
	 *
	 * @param string $key
	 *
	 * @return Gamestring
	 *
	 * @throws RuntimeException For missing key
	 */
	public function string(string $key): Gamestring
	{
		if (! array_key_exists($key, $this->strings))
		{
			throw new RuntimeException('String not found for ' . $key);
		}

		return $this->strings[$key];
	}

	/**
	 * Returns all Gamestrings.
	 *
	 * @return array<string,Gamestring>
	 */
	public function strings(): array
	{
		return $this->strings;
	}
}
