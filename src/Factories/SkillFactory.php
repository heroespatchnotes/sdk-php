<?php

declare(strict_types=1);

namespace Heroes\Factories;

use Heroes\Entities\Skill;
use Heroes\Providers\DataProvider;
use ArrayIterator;
use Traversable;

/**
 * Skill Factory
 *
 * Common Factory methods for
 * Abilities and Talents.
 */
abstract class SkillFactory extends BaseFactory
{
	/**
	 * Group to use for the Data Provider
	 *
	 * @var string
	 */
	protected $group = DataProvider::HERO;

	/**
	 * Searches StringProvider for relevant strings
	 * and adds them to the contents.
	 *
	 * @param object $contents
	 *
	 * @return void
	 */
	protected function injectStrings(object &$contents): void
	{
		// Harvest the relevant strings
		$skillId = Skill::createId($contents);
		$strings = [];
		foreach (['full', 'name', 'short', 'cooldown'] as $key)
		{
			if (isset($this->strings->gamestrings->abiltalent->$key->$skillId))
			{
				// Add them to the contents
				$contents->$key = $this->strings->gamestrings->abiltalent->$key->$skillId;
			}
		}
	}

	/**
	 * Returns a Hero's Skills
	 *
	 * @param string $heroId
	 *
	 * @return array<Skill>
	 */
	abstract public function hero(string $heroId): array;

	/**
	 * Returns an iterable version of all Skills.
	 *
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		$skills = [];

		foreach ($this->data->getContents() as $heroId => $heroContents)
		{
			$skills = array_merge($skills, $this->hero($heroId));
		}

		return new ArrayIterator($skills);
	}
}
