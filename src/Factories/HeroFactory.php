<?php

declare(strict_types=1);

namespace Heroes\Factories;

use Heroes\Entities\Hero;
use Heroes\Providers\DataProvider;

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
	 * Path to the Entity's game Strings.
	 *
	 * @var string
	 */
	protected $subGroup = 'unit';

	/**
	 * @var Hero[]|null
	 */
	protected $entities;

	/**
	 * Creates the array of Heroes and its heroId index.
	 *
	 * @return void
	 */
	protected function build(): void
	{
		$abilities = new AbilityFactory($this->strings->getGroup(), $this->data->getPatch());
		$talents   = new TalentFactory($this->strings->getGroup(), $this->data->getPatch());
		$index     = 0;

		$this->entities = [];
		foreach ($this->data->getContents() as $heroId => $heroContents)
		{
			// Use the other factories to get related Entities
			$this->entities[$index] = new Hero($heroId, $abilities->hero($heroId), $talents->hero($heroId), $heroContents, $this->fetchStrings($heroId));
			$this->ids[$heroId]     = $index;
			$index++;
		}
	}
}
