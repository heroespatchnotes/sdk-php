<?php

declare(strict_types=1);

namespace Tatter\Heroes\Entities;

use Tatter\Heroes\Providers\DataProvider;
use Tatter\Heroes\Providers\GamestringProvider;
use RuntimeException;

/**
 * Skill Entity
 *
 * Basis for Abilities and Talents.
 */
abstract class Skill extends BaseEntity
{
	/**
	 * @var string
	 */
	protected $heroId;

	/**
	 * Builds the ID from skill contents.
	 *
	 * @return string
	 */
	public static function createId(object $contents): string
	{
		$values = [];
		foreach (['nameId', 'buttonId', 'abilityType'] as $key)
		{
			$values[] = $contents->$key;
		}
		$values[] = isset($contents->isPassive) ? 'True' : 'False';

		return implode('|', $values);
	}

	/**
	 * Builds the ID dynamically from contents.
	 *
	 * @return string
	 */
	public function id(): string
	{
		if (is_null($this->id))
		{
			$this->id = self::createId($this->contents);
		}

		return parent::id();
	}

	/**
	 * Returns the Hero ID.
	 *
	 * @return string
	 */
	public function hero(): string
	{
		return $this->heroId;
	}
}
