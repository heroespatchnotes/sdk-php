<?php

declare(strict_types=1);

namespace Heroes\Factories;

use Heroes\Entities\BaseEntity;
use Heroes\Gamestring;
use Heroes\Providers\DataProvider;
use Heroes\Providers\StringProvider;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

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
	protected $subGroup;

	/**
	 * @var DataProvider
	 */
	protected $data;

	/**
	 * @var StringProvider
	 */
	protected $strings;

	/**
	 * Index of BaseEntity::id() to the key in $entities
	 *
	 * @var array<string,int>
	 */
	protected $ids = [];

	/**
	 * @var BaseEntity[]|null
	 */
	protected $entities;

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
	 * @param string $id Equivalent of BaseEntity::id()
	 *
	 * @return array<string,Gamestring>
	 */
	protected function fetchStrings(string $id): array
	{
		// Harvest the relevant strings
		$strings = [];
		foreach ($this->strings->gamestrings->{$this->subGroup} as $key => $contents)
		{
			$strings[$key] = isset($contents->$id) ? new Gamestring($contents->$id) : null;
		}

		return $strings;
	}

	/**
	 * Returns a single Entity by its ID.
	 *
	 * @param string $id Equivalent to BaseEntity::id()
	 *
	 * @return BaseEntity|null
	 */
	public function get(string $id): ?BaseEntity
	{
		if (is_null($this->entities))
		{
			$this->build();
		}

		if (array_key_exists($id, $this->ids))
		{
			return $this->entities[$this->ids[$id]];
		}

		return null;
	}

	/**
	 * Returns an iterable version of the stored Entities.
	 *
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		if (is_null($this->entities))
		{
			$this->build();
		}

		return new ArrayIterator($this->entities);
	}

	/**
	 * Creates the arrays of Entities and indexes.
	 *
	 * @return void
	 */
	abstract protected function build(): void;
}
