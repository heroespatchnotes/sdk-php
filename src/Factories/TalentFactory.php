<?php

declare(strict_types=1);

namespace Tatter\Heroes\Factories;

use Tatter\Heroes\Entities\Talent;
use Tatter\Heroes\Providers\DataProvider;
use Traversable;

/**
 * Talent Factory
 *
 * Uses a Hero DataProvider to
 * create Talents.
 */
class TalentFactory extends BaseFactory
{
	/**
	 * Group to use for the Data Provider
	 *
	 * @var string
	 */
	protected $group = DataProvider::HERO;

	/**
	 * Returns a Hero's Talents
	 *
	 * @param string $heroId
	 *
	 * @return array<Talent>
	 */
	public function hero(string $heroId): array
	{
		$talents = [];

		foreach ($this->data->getContents()->$heroId->talents as $levelId => $contents)
		{
			// Harvest the relevant strings
			$talentId = Talent::createId($contents);
			$strings  = [];
			foreach (['full', 'name', 'short'] as $key)
			{
				$contents->$key = $this->strings->gamestrings->abiltalent->$key->$talentId;
			}
			if (isset($this->strings->gamestrings->abiltalent->cooldown->$talentId))
			{
				$contents->cooldown = $this->strings->gamestrings->abiltalent->cooldown->$talentId;
			}

			$talents[] = new Talent($heroId, $levelId, $contents);
		}

		return $talents;
	}

	/**
	 * Returns an array of all Talents.
	 *
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
	}
}
