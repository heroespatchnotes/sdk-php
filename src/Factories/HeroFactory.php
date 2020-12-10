<?php

declare(strict_types=1);

namespace Tatter\Heroes\Factories;

use Tatter\Heroes\Entities\Hero;

/**
 * Hero Factory
 *
 * Uses or creates a Hero DataProvider
 * to generate hero data.
 */
class HeroFactory extends BaseFactory
{
	/**
	 * Group to use for the Data Provider
	 *
	 * @var string
	 */
	protected $group = DataProvider::HERO;

	/**
	 * Returns a hero identified by $heroId
	 *
	 * @param string $heroId
	 *
	 * @return Hero
	 */
	public function get(string $heroId): Hero
	{
		return new Hero($heroId, $this->data->$heroId, $this->gamestrings);
	}

	/**
	 * Returns the data as an iterator.
	 *
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return [];
	}
}
