<?php

declare(strict_types=1);

namespace Heroes\Entities;

use Heroes\Gamestring;

/**
 * Ability Entity
 */
class Ability extends Skill
{
	/**
	 * @var string
	 */
	private $unitId;

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var bool
	 */
	private $sub;

	/**
	 * Builds the Talent
	 *
	 * @param string $heroId
	 * @param string $unitId
	 * @param string $type
	 * @param bool $sub
	 * @param object $contents Data from Provider for a single Ability
	 * @param array<string,Gamestring> $strings Relevant Gamestrings from Provider
	 */
	public function __construct(string $heroId, string $unitId, string $type, bool $sub, object $contents, array $strings)
	{
		$this->heroId   = $heroId;
		$this->unitId   = $unitId;
		$this->type     = $type;
		$this->sub      = $sub;
		$this->contents = $contents;
		$this->strings  = $strings;
	}

	/**
	 * Returns the Ability unit/subunit ID.
	 *
	 * @return string
	 */
	public function unit(): string
	{
		return $this->unitId;
	}

	/**
	 * @return string
	 */
	public function type(): string
	{
		return $this->type;
	}

	/**
	 * @return bool
	 */
	public function sub(): bool
	{
		return $this->sub;
	}
}
