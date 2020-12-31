<?php

declare(strict_types=1);

namespace Heroes\Factories;

use Heroes\Entities\Skill;
use Heroes\Entities\Talent;
use Heroes\Providers\DataProvider;
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
	 * @var Talent[]
	 */
	protected $entities;

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
				$skillId = Skill::createId($contents);
				$strings = $this->getStrings($skillId);

				$talents[] = new Talent($heroId, $levelId, $contents, $strings);
			}
		}

		return $talents;
	}
}
