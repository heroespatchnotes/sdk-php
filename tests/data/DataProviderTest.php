<?php

use Tatter\Heroes\Providers\DataProvider;
use Tests\Support\TestCase;

class DataProviderTest extends TestCase
{
	public function testConstructorThrowsInvalidGroup()
	{
		$this->expectException('RuntimeException');
		$this->expectExceptionMessage('Source file missing:');

		$provider = DataProvider::get('bitcoins');
	}

	public function testGetGroup()
	{
		$provider = DataProvider::get(DataProvider::HERO);

		$result = $provider->getGroup();

		$this->assertEquals('hero', $result);
	}

	public function testGetSource()
	{
		$provider = DataProvider::get(DataProvider::HERO, $this->patch);
		$expected = 'heroesdata' . DIRECTORY_SEPARATOR . $this->patch . DIRECTORY_SEPARATOR . 'data';

		$result = $provider->getSource();

		$this->assertStringContainsString($expected, $result);
	}

	public function testGetSourceFallsBackOnDuplicate()
	{
		$provider = DataProvider::get(DataProvider::HERO, '2.48.3.77205');
		$expected = '2.48.2.76893';

		$result = $provider->getSource();

		$this->assertStringContainsString($expected, $result);
	}

	public function testConstructorLoadsData()
	{
		$provider = DataProvider::get(DataProvider::HERO);

		$result = $provider->Abathur;
		$this->assertIsObject($result);

		$result = $provider->Abathur->unitId;
		$this->assertEquals('HeroAbathur', $result);
	}
}
