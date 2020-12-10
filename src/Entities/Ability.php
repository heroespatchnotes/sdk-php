<?php

declare(strict_types=1);

namespace Tatter\Heroes\Entities;

/**
 * Ability Entity
 */
class Ability extends Skill
{
	/**
	 * Builds the Talent
	 *
	 * @param string $heroId
	 * @param object $contents Data from Provider for a single Talent
	 */
	public function __construct(string $heroId, object $contents)
	{
		$this->heroId   = $heroId;
		$this->contents = $contents;
	}
}
