<?php

declare(strict_types=1);

namespace Heroes\Factories;

use Heroes\Entities\Ability;
use Heroes\Entities\Skill;
use Heroes\Entities\Talent;
use Heroes\Providers\DataProvider;

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
	 * Path to the Entity's game Strings.
	 *
	 * @var string
	 */
	protected $subGroup = 'abiltalent';

	/**
	 * Index of nameId to the key in $entities
	 *
	 * @var array<string,int>
	 */
	protected $nameIds = [];

	/**
	 * @var Ability[]|Talent[]|null
	 */
	protected $entities;

	/**
	 * Returns a Hero's Skills
	 *
	 * @param string $heroId
	 *
	 * @return array<Skill>
	 */
	abstract public function hero(string $heroId): array;

	/**
	 * Creates the array of Skills and indexes of
	 * the Skill's ID and nameId.
	 *
	 * @return void
	 */
	protected function build(): void
	{
		$index          = 0;
		$this->entities = [];

		foreach ($this->data->getContents() as $heroId => $heroContents)
		{
			foreach ($this->hero($heroId) as $skill)
			{
				$this->entities[$index]        = $skill;
				$this->ids[$skill->id()]       = $index;
				$this->nameIds[$skill->nameId] = $index;

				$index++;
			}
		}
	}

	/**
	 * Returns a single Entity by its nameId.
	 *
	 * @param string $nameId
	 *
	 * @return Ability|Talent|null
	 */
	public function getByNameId(string $nameId): ?Skill
	{
		if (is_null($this->entities))
		{
			$this->build();
		}

		if (array_key_exists($nameId, $this->nameIds))
		{
			return $this->entities[$this->nameIds[$nameId]];
		}

		return null;
	}
}
