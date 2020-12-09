<?php

declare(strict_types=1);

namespace Tatter\Heroes\Providers;

use Tatter\Heroes\Locator;
use Tatter\Heroes\Interfaces\ProviderInterface;
use JsonException;
use RuntimeException;

/**
 * Gamestring Provider Class
 *
 * Handles locating, reading, and storing
 * locale-specific games strings from
 * Heroes Tool Chest.
 */
class GamestringProvider extends BaseProvider
{
	use ProviderTrait;

	/**
	 * Locale Groups and Filenames
	 */
	const GERMANY = 'dede';
	const USA     = 'enus';
	const SPAIN   = 'eses';
	const MEXICO  = 'esmx';
	const FRANCE  = 'frfr';
	const ITALY   = 'itit';
	const KOREA   = 'kokr';
	const POLAND  = 'plpl';
	const BRAZIL  = 'ptbr';
	const RUSSIA  = 'ruru';
	const CHINA   = 'zhcn';
	const TAIWAN  = 'zhtw';

	/**
	 * Returns the pattern used to locate the source
	 * file within its de-duplicated directory.
	 *
	 * @return string
	 */
	protected function getPattern(): string
	{
		return $this->getDirectory() . 'gamestrings_*_' . $this->getGroup() . '.json';
	}
	
	/**
	 * Returns the de-duplicated directory.
	 *
	 * @return string
	 *
	 * @throws RuntimeException For missing directory
	 */
	private function getDirectory(): string
	{
		$guesses = [Locator::getPatchPath($this->getPatch())];

		// If this patch has a duplicate then try it too
		$metaData = $this->getMetaData();
		if (isset($metaData->duplicate->gamestring))
		{
			$guesses[] = Locator::getPatchPath($metaData->duplicate->gamestring);
		}

		foreach ($guesses as $patchDir)
		{
			if (is_dir($patchDir . 'gamestrings'))
			{
				return $patchDir . 'gamestrings' . DIRECTORY_SEPARATOR;
			}
		}

		throw new RuntimeException('Unable to locate gamestring directory for patch ' . $this->getPatch());
	}
}
