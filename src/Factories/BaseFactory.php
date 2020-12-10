<?php

declare(strict_types=1);

namespace Tatter\Heroes\Factories;

use Tatter\Heroes\Providers\DataProvider;
use Tatter\Heroes\Providers\StringProvider;
use IteratorAggregate;

/**
 * Base Factory
 *
 * Common methods for factories.
 */
abstract class BaseFactory implements IteratorAggregate
{
	/**
	 * Group to use for the Data Provider. Set by child.
	 *
	 * @var string
	 */
	protected $group;

	/**
	 * @var DataProvider
	 */
	protected $data;

	/**
	 * @var StringProvider
	 */
	protected $strings;

	/**
	 * Initializes the Providers
	 *
	 * @param string|null $locale Locale for game strings, null for "enus"
	 * @param string|null $patch  Patch to use, null for latest
	 */
	public function __construct(string $locale = null, string $patch = null)
	{
		$this->data    = DataProvider::get($this->group, $patch);
		$this->strings = StringProvider::get($locale ?? StringProvider::USA, $patch);
	}
}
