<?php

declare(strict_types=1);

namespace Tatter\Heroes\Entities;

use Tatter\Heroes\Entities\Hero;
use Tatter\Heroes\Providers\DataProvider;
use Tatter\Heroes\Providers\GamestringProvider;
use RuntimeException;

/**
 * Hero Entity
 */
class Hero
{
	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var DataProvider
	 */
	private $data;

	/**
	 * @var GamestringProvider
	 */
	private $gamestrings;

	/**
	 * Builds the Hero from the herodata and gamestrings
	 *
	 * @param string $id          The "hyperlink" hero ID
	 * @param object $herodata    Game data from Provider for a single hero
	 * @param object $gamestrings Gamestrings from Provider for a single hero
	 *
	 * @throws RuntimeException For missing file
	 */
	public function __construct(string $id, object $herodata, object $gamestrings)
	{
		$this->id = $id;
	}
	
	/**
	 * Returns the ID.
	 *
	 * @return string
	 */
	public function id(): string
	{
		return $this->id;
	}
}
