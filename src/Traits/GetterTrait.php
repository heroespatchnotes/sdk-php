<?php

declare(strict_types=1);

namespace Tatter\Heroes\Traits;

/**
 * Getter Trait
 *
 * Generic magic getters for class contents.
 */
trait GetterTrait
{
	/**
	 * The source file contents.
	 *
	 * @var object
	 */
	protected $contents;

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get(string $name)
	{
		return $this->contents->$name;
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function __isset(string $name): bool
	{
		return property_exists($this->contents, $name);
	}
}
