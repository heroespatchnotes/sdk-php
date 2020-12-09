<?php

declare(strict_types=1);

namespace Tatter\Heroes\Providers;

use Tatter\Heroes\Locator;
use Tatter\Heroes\Interfaces\ProviderInterface;
use JsonException;
use RuntimeException;

/**
 * Data Provider Class
 *
 * Handles locating, reading, and storing game
 * data from Heroes Tool Chest.
 */
class DataProvider extends BaseProvider
{
	use ProviderTrait;

	/**
	 * Data Groups and Filenames
	 */
	const ANNOUNCER         = 'announcer';
	const BANNER            = 'banner';
	const BEHAVIORVETERANCY = 'behaviorveterancy';
	const EMOTICON          = 'emoticon';
	const EMOTICONPACK      = 'emoticonpack';
	const HERO              = 'hero';
	const HEROSKIN          = 'heroskin';
	const MATCHAWARD        = 'matchaward';
	const MOUNT             = 'mount';
	const PORTRAIT          = 'portrait';
	const PORTRAITPACK      = 'portraitpack';
	const REWARDPORTRAIT    = 'rewardportrait';
	const SPRAY             = 'spray';
	const UNIT              = 'unit';
	const VOICELINE         = 'voiceline';

	/**
	 * Returns the pattern used to locate the source
	 * file within its de-duplicated directory.
	 *
	 * @return string
	 */
	protected function getPattern(): string
	{
		return $this->getDirectory() . $this->getGroup() . 'data_*_localized.json';
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
		if (isset($metaData->duplicate->data))
		{
			$guesses[] = Locator::getPatchPath($metaData->duplicate->data);
		}

		foreach ($guesses as $patchDir)
		{
			if (is_dir($patchDir . 'data'))
			{
				return $patchDir . 'data' . DIRECTORY_SEPARATOR;
			}
		}

		throw new RuntimeException('Unable to locate data directory for patch ' . $this->getPatch());
	}
}
