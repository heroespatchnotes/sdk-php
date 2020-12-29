<?php

use Heroes\Entities\Hero;
use Heroes\Factories\HeroFactory;
use Heroes\Gamestring;
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

	public function testPassesStrings()
	{
		$hero = $this->heroes->get('Abathur');

		foreach ([
			'description',
			'difficulty',
			'name',
			'role',
		] as $key)
		{
			$this->assertInstanceOf(Gamestring::class, $hero->string($key));
		}
	}
}
