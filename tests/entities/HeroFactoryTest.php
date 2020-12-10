<?php

use Tatter\Heroes\Entities\Hero;
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

	public function testHeroesAreIterable()
	{
		$this->assertTrue(is_iterable($this->heroes));
	}

	public function testGetsHero()
	{
		$result = $this->heroes->get('Abathur');
		$this->assertInstanceOf(Hero::class, $result);

		$this->assertEquals('Abathur', $result->id());
	}
}
