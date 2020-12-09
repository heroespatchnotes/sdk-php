<?php

declare(strict_types=1);

namespace Tatter\Heroes\Providers;

use Tatter\Heroes\Interfaces\ProviderInterface;

/**
 * Provider Trait
 *
 * Static constructor to return an instance
 * of the child Provider.
 */
trait ProviderTrait
{
	/**
	 * Returns a new/shared instance.
	 *
	 * @param string $group      The group
	 * @param string|null $patch The patch version, or null to use latest
	 *
	 * @return ProviderInterface
	 */
	public static function get(string $group, string $patch = null): self
	{
		return parent::get($group, $patch);
	}
}
