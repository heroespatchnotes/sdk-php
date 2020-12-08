<?php

declare(strict_types=1);

namespace Tatter\Heroes\Providers;

use Tatter\Heroes\Locator;
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
	 * @var string
	 */
	private $group;
	
	/**
	 * Sets the group then loads the data
	 *
	 * @param string $group      The name/filename for the group
	 * @param string $patch|null The patch version, or null to use latest
	 *
	 * @throws RuntimeException For missing file
	 * @throws JsonException    For invalid file
	 */
	public function __construct(string $group, string $patch = null)
	{
		parent::__construct($patch);

		$this->group = $group;

		// Check for the actual file
		$short = Locator::shortPatch($this->getPatch());
		$file  = $this->getDirectory() . $this->group . 'data_' . $short . '_localized.json';

		if (! is_file($file))
		{
			throw new RuntimeException('Data file missing: ' . $file);
		}

		$this->data = json_decode(file_get_contents($file), false, JSON_THROW_ON_ERROR);
	}
	
	/**
	 * Returns the group.
	 *
	 * @return string
	 */
	public function getGroup(): string
	{
		return $this->group;
	}
	
	/**
	 * Returns the de-duplicated directory.
	 *
	 * @return string
	 *
	 * @throws RuntimeException For missing directory
	 */
	public function getDirectory(): string
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
