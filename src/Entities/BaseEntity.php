<?php

declare(strict_types=1);

namespace Heroes\Entities;

use Heroes\Gamestring;

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
	 */
	public function string(string $key): Gamestring
	{
		return $this->strings[$key];
	}
}
