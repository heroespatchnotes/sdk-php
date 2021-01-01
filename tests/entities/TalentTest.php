<?php

use Heroes\Entities\Talent;
use Heroes\Factories\TalentFactory;
use Heroes\Gamestring;
use Tests\Support\TestCase;

class TalentTest extends TestCase
{
	/**
	 * @var Talent|null
	 */
	private $talent;

	protected function setUp(): void
	{
		if (is_null($this->talent))
		{
			$this->talent = (new TalentFactory)->getByNameId('AbathurMasteryPressurizedGlands');
		}
	}

	public function testMagicGet()
	{
		$result = $this->talent->abilityType;

		$this->assertEquals('W', $result);
	}

	public function testLevel()
	{
		$result = $this->talent->level();

		$this->assertEquals('level1', $result);
	}

	public function testAbilities()
	{
		$expected = ['AbathurSymbiote', 'AbathurSymbioteSpikeBurst'];
		$result   = $this->talent->abilities();

		$this->assertEquals($expected, $result);
	}
}
