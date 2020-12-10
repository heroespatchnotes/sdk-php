<?php

declare(strict_types=1);

namespace Tatter\Heroes\Entities;

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
	 */
	public function __construct(string $heroId, string $unitId, string $type, bool $sub, object $contents)
	{
		$this->heroId   = $heroId;
		$this->unitId   = $unitId;
		$this->type     = $type;
		$this->sub      = $sub;
		$this->contents = $contents;
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
