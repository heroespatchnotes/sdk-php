<?php

use Heroes\Entities\Ability;
use Heroes\Entities\Hero;
use Heroes\Entities\Talent;
use Heroes\Factories\HeroFactory;
use Heroes\Gamestring;
use Tests\Support\TestCase;

class HeroTest extends TestCase
{
	/**
	 * @var Hero|null
	 */
	private $hero;

	protected function setUp(): void
	{
		if (is_null($this->hero))
		{
			$this->hero = (new HeroFactory)->get('Abathur'); // @phpstan-ignore-line
		}
	}

	public function testMagicGet()
	{
		$result = $this->hero->abilities->basic[0]->abilityType;

		$this->assertEquals('Q', $result);
	}

	public function testAbilities()
	{
		$result = $this->hero->abilities();

		$this->assertIsArray($result);
		$this->assertInstanceOf(Ability::class, $result[0]);
		$this->assertEquals('Abathur', $result[0]->hero());
	}

	public function testTalents()
	{
		$result = $this->hero->talents();

		$this->assertIsArray($result);
		$this->assertInstanceOf(Talent::class, $result[0]);
		$this->assertEquals('Abathur', $result[0]->hero());
	}
}
