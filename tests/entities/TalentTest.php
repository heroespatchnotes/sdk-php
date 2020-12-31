<?php

use Heroes\Entities\Talent;
use Heroes\Factories\TalentFactory;
use Heroes\Gamestring;
use Tests\Support\TestCase;

class TalentTest extends TestCase
{
	/**
	 * @var TalentFactory|null
	 */
	private $talents;

	/**
	 * @var Talent
	 */
	private $talent;

	protected function setUp(): void
	{
		if (is_null($this->talents))
		{
			$this->talents = new TalentFactory();
		}

		$this->talent = $this->talents->getByNameId('AbathurMasteryPressurizedGlands');
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
