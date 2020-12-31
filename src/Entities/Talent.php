<?php

declare(strict_types=1);

namespace Heroes\Entities;

use Heroes\Gamestring;

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
	 * @param array<string,Gamestring> $strings Relevant Gamestrings from Provider
	 */
	public function __construct(string $heroId, string $levelId, object $contents, array $strings)
	{
		$this->heroId   = $heroId;
		$this->levelId  = $levelId;
		$this->contents = $contents;
		$this->strings  = $strings;
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
	 * Returns the nameIds for linked Abilities.
	 *
	 * @return string[]
	 */
	public function abilities(): array
	{
		return $this->__isset('abilityTalentLinkIds') ? $this->__get('abilityTalentLinkIds') : [];
	}
}
