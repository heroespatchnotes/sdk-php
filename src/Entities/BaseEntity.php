<?php

declare(strict_types=1);

namespace Tatter\Heroes\Entities;

/**
 * Base Entity
 */
abstract class BaseEntity
{
	use \Tatter\Heroes\Traits\GetterTrait;

	/**
	 * @var string|null
	 */
	protected $id;

	/**
	 * Returns the Entity ID.
	 *
	 * @return string
	 */
	public function id(): string
	{
		return $this->id;
	}
}
