<?php

declare(strict_types=1);

namespace Heroes;

use Heroes\Providers\DataProvider;
use Heroes\Providers\StringProvider;


/**
 * Base Differ
 *
 * Common methods for differs.
 */
abstract class BaseDiffer
{
	/**
	 * Group to use for the Data Providers. Set by child.
	 *
	 * @var string
	 */
	protected $group;

	/**
	 * @var DataProvider
	 */
	protected $data1;

	/**
	 * @var DataProvider
	 */
	protected $data2;

	/**
	 * @var StringProvider
	 */
	protected $strings1;

	/**
	 * @var StringProvider
	 */
	protected $strings2;

	/**
	 * Initializes the Providers
	 *
	 * @param string $patch1      Primary patch
	 * @param string|null $patch2 Patch to compare, null for latest
	 * @param string|null $locale Locale for game strings, null for "enus"
	 */
	public function __construct(string $patch1, string $patch2 = null, string $locale = null)
	{
		$this->data1    = DataProvider::get($this->group, $patch1);
		$this->data2    = DataProvider::get($this->group, $patch2);
		$this->strings1 = StringProvider::get($locale ?? StringProvider::USA, $patch1);
		$this->strings2 = StringProvider::get($locale ?? StringProvider::USA, $patch2);
	}
}
