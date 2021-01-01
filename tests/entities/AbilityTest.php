<?php

use Heroes\Entities\Ability;
use Heroes\Factories\AbilityFactory;
use Heroes\Gamestring;
use Tests\Support\TestCase;

class AbilityTest extends TestCase
{
	/**
	 * @var Ability|null
	 */
	private $ability;

	protected function setUp(): void
	{
		if (is_null($this->ability))
		{
			$this->ability = (new AbilityFactory)->getByNameId('AbathurEvolveMonstrosity');
		}
	}

	public function testMagicGet()
	{
		$result = $this->ability->abilityType;

		$this->assertEquals('Heroic', $result);
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
