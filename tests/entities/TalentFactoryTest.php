<?php

use Heroes\Entities\Talent;
use Heroes\Factories\TalentFactory;
use Tests\Support\TestCase;

class TalentFactoryTest extends TestCase
{
	/**
	 * @var TalentFactory
	 */
	private $talents;

	protected function setUp(): void
	{
		$this->talents = new TalentFactory();
	}

	public function testTalentsAreIterable()
	{
		$this->assertTrue(is_iterable($this->talents));
	}

	public function testGetsTalent()
	{
		$result = $this->talents->get('AbathurMasteryPressurizedGlands|AbathurSymbiotePressurizedGlandsTalent|W|False');
		$this->assertInstanceOf(Talent::class, $result);

		$this->assertEquals('AbathurMasteryPressurizedGlands', $result->nameId);
	}

	public function testGetsHeroTalents()
	{
		$talents = $this->talents->hero('Abathur');
		$this->assertIsArray($talents);

		$talent = $talents[0];
		$this->assertEquals('Abathur', $talent->hero());
	}

	public function testGetByNameId()
	{
		$result = $this->talents->getByNameId('AbathurMasteryPressurizedGlands');

		$this->assertInstanceOf(Talent::class, $result);
		$this->assertEquals('W', $result->abilityType);
	}
}
