<?php

declare(strict_types=1);

namespace Tatter\Heroes\Factories;

use Tatter\Heroes\Entities\Talent;
use Tatter\Heroes\Providers\DataProvider;
use ArrayIterator;
use Traversable;

/**
 * Talent Factory
 *
 * Uses a Hero DataProvider to
 * create Talents.
 */
class TalentFactory extends SkillFactory
{
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

		foreach ($this->data->getContents()->$heroId->talents as $levelId => $collection)
		{
			foreach ($collection as $contents)
			{
				$this->injectStrings($contents);

				$talents[] = new Talent($heroId, $levelId, $contents);
			}
		}

		return $talents;
	}
}
