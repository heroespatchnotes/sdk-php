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
	use \Tatter\Heroes\Traits\ProviderTrait;

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
	 * Returns the pattern used to locate the source
	 * file within its de-duplicated directory.
	 *
	 * @return string
	 */
	public function getPattern(): string
	{
		return __DIR__ . DIRECTORY_SEPARATOR . 'test.json';
	}
}
