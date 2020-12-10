<?php

declare(strict_types=1);

namespace Tatter\Heroes\Entities;

/**
 * Talent Entity
 */
class Talent extends Skill
{
	/**
	 * @var string
	 */
	private $levelId;

	/**
	 * Builds the Talent
	 *
	 * @param string $heroId
	 * @param string $levelId
	 * @param object $contents Data from Provider for a single Talent
	 */
	public function __construct(string $heroId, string $levelId, object $contents)
	{
		$this->heroId   = $heroId;
		$this->levelId  = $levelId;
		$this->contents = $contents;
	}

	/**
	 * Returns the Talent levelId.
	 * E.g. "level4"
	 *
	 * @return string
	 */
	public function level(): string
	{
		return $this->levelId;
	}

	/**
	 * Returns the linked Abilities.
	 *
	 * @return Ability[]
	 */
	public function abilities(): array
	{
		return [];
	}
}
