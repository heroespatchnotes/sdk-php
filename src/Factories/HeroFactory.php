<?php

declare(strict_types=1);

namespace Tatter\Heroes\Factories;

use Tatter\Heroes\Entities\Hero;
use Tatter\Heroes\Providers\DataProvider;
use Tatter\Heroes\Providers\GamestringProvider;
use RuntimeException;

/**
 * Hero Factory
 *
 * Uses or creates a Hero DataProvider
 * to generate hero data.
 */
class HeroFactory
{
	/**
	 * @var DataProvider
	 */
	private $data;

	/**
	 * @var GamestringProvider
	 */
	private $gamestrings;

	/**
	 * Initializes the DataProvider
	 *
	 * @param DataProvider|null $provider A Hero Data Provider
	 *
	 * @throws RuntimeException For missing file
	 */
	public function __construct(DataProvider $data = null, GamestringProvider $gamestrings = null)
	{
		$this->data        = $data ?? new DataProvider(DataProvider::HERO);
		$this->gamestrings = $gamestrings ?? new GamestringProvider(GamestringProvider::USA);

		if ($this->data->getGroup() !== 'hero')
		{
			throw new RuntimeException('Data Provider group must match the factory');
		}
	}

	/**
	 * Returns a hero identified by $heroId
	 *
	 * @param string $heroId
	 *
	 * @return Hero
	 */
	public function get(string $heroId): Hero
	{
		return new Hero($heroId, $this->data->$heroId, $this->gamestrings);
	}
}
