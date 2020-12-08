<?php

declare(strict_types=1);

namespace Tests\Support;

use Tatter\Heroes\Locator;
use Tatter\Heroes\Providers\BaseProvider;
use JsonException;
use RuntimeException;

/**
 * Dummy Provider Class
 *
 * Exposes BaseProvider methods for testing
 */
class DummyProvider extends BaseProvider
{
	/**
	 * Does not set the patch.
	 */
	public function __construct()
	{
	}

	/**
	 * Verifies and stores a patch version.
	 *
	 * @param string $patch The patch version
	 *
	 * @throws RuntimeException For missing patch directory
	 * @throws JsonException    For invalid metadata file
	 */
	public function setPatch(string $patch)
	{
		parent::setPatch($patch);
	}

	/**
	 * Returns the de-duplicated directory.
	 *
	 * @param bool $success
	 *
	 * @return string
	 *
	 * @throws RuntimeException For missing directory
	 */
	public function getDirectory($success = true): string
	{
		if ($success)
		{
			return Locator::normalizeDirectory(__DIR__);
		}

		throw new RuntimeException('Unable to locate data directory');
	}
}
