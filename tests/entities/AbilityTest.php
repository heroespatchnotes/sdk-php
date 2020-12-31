<?php

use Heroes\Entities\Ability;
use Heroes\Factories\AbilityFactory;
use Heroes\Gamestring;
use Tests\Support\TestCase;

class AbilityTest extends TestCase
{
	/**
	 * @var AbilityFactory|null
	 */
	private $abilities;

	/**
	 * @var Ability
	 */
	private $ability;

	protected function setUp(): void
	{
		if (is_null($this->abilities))
		{
			$this->abilities = new AbilityFactory();
		}

		$this->ability = $this->abilities->getByNameId('AbathurEvolveMonstrosity');
	}

	public function testUnitId()
	{
		$result = $this->ability->unit();

		$this->assertEquals('HeroAbathur', $result);
	}

	public function testType()
	{
		$result = $this->ability->type();

		$this->assertEquals('heroic', $result);
	}

	public function testSub()
	{
		$result = $this->ability->unit();

		$this->assertFalse(false, $result);
	}
}
