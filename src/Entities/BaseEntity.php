<?php

declare(strict_types=1);

namespace Heroes\Entities;

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
	 * @var array<string,string>
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
	 * Returns a String by its name.
	 *
	 * @param string $key
	 *
	 * @return string
	 */
	public function string(string $key): string
	{
		return $this->strings[$key];
	}
}
