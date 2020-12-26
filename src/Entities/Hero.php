<?php

declare(strict_types=1);

namespace Heroes\Entities;

use Heroes\Entities\Hero;
use Heroes\Providers\DataProvider;
use Heroes\Providers\GamestringProvider;
use RuntimeException;

/**
 * Hero Entity
 */
class Hero extends BaseEntity
{
	/**
	 * @var Ability[]
	 */
	private $abilities;

	/**
	 * @var Talent[]
	 */
	private $talents;

	/**
	 * Builds the Hero
	 *
	 * @param string $heroId
	 * @param array $abilities
	 * @param array $talents
	 * @param array<string,string> $strings
	 */
	public function __construct(string $heroId, array $abilities, array $talents, array $strings)
	{
		$this->id        = $heroId;
		$this->abilities = $abilities;
		$this->talents   = $talents;
		$this->strings   = $strings;
	}

	/**
	 * Returns the Abilities, optionally filtered by $unitId.
	 *
	 * @param string|null $unitId
	 *
	 * @return Ability[]
	 */
	public function abilities(string $unitId = null): array
	{
		if (is_null($unitId))
		{
			return $this->abilities;
		}

		$abilities = [];
		foreach ($this->abilities as $ability)
		{
			if ($ability->unit() === $unitId)
			{
				$abilities[] = $ability;
			}
		}

		return $abilities;
	}

	/**
	 * Returns the Talents, optionally filtered by $levelId.
	 *
	 * @param int|null $level
	 *
	 * @return Talent[]
	 */
	public function talents(int $level = null): array
	{
		if (is_null($level))
		{
			return $this->talents;
		}

		$levelId = 'level' . (string) $level;
		$talents = [];
		foreach ($this->talents as $talent)
		{
			if ($talent->level() === $levelId)
			{
				$talents[] = $talent;
			}
		}

		return $talents;
	}
}
