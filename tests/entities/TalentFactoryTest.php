<?php

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

	public function testGetsHeroTalents()
	{
		$talents = $this->talents->hero('Abathur');
		$this->assertIsArray($talents);

		$talent = $talents[0];
		$this->assertEquals('Abathur', $talent->hero());
	}
}
