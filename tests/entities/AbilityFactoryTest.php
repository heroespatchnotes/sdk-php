<?php

use Tatter\Heroes\Factories\AbilityFactory;
use Tests\Support\TestCase;

class AbilityFactoryTest extends TestCase
{
	/**
	 * @var AbilityFactory
	 */
	private $abilities;

	protected function setUp(): void
	{
		$this->abilities = new AbilityFactory();
	}

	public function testAbilitiesAreIterable()
	{
		$this->assertTrue(is_iterable($this->abilities));
	}

	public function testGetsHeroAbilities()
	{
		$abilities = $this->abilities->hero('Abathur');
		$this->assertIsArray($abilities);

		$ability = $abilities[0];
		$this->assertEquals('Abathur', $ability->hero());
		$this->assertEquals('HeroAbathur', $ability->unit());
		$this->assertEquals('basic', $ability->type());
		$this->assertEquals(false, $ability->sub());
	}
}
