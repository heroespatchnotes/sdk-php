<?php

use Tatter\Heroes\Factories\HeroFactory;
use Tests\Support\TestCase;

class HeroFactoryTest extends TestCase
{
	/**
	 * @var HeroFactory
	 */
	private $heroes;

	protected function setUp(): void
	{
		$this->heroes = new HeroFactory();
	}
}
