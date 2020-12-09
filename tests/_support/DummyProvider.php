<?php

declare(strict_types=1);

namespace Tests\Support;

use Tatter\Heroes\Locator;
use Tatter\Heroes\Providers\DataProvider;
use JsonException;
use RuntimeException;

/**
 * Dummy Provider Class
 *
 * Exposes BaseProvider methods for testing
 */
class DummyProvider extends DataProvider
{
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
}
