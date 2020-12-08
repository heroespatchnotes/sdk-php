<?php

use Tatter\Heroes\Providers\DataProvider;
use Tests\Support\TestCase;

class DataProviderTest extends TestCase
{
	public function testConstructorThrowsInvalidGroup()
	{
		$this->expectException('RuntimeException');
		$this->expectExceptionMessage('Data file missing:');

		$provider = new DataProvider('bitcoins');
	}

	public function testGetGroup()
	{
		$provider = new DataProvider(DataProvider::HERO);

		$result = $provider->getGroup();

		$this->assertEquals('hero', $result);
	}

	public function testGetDirectory()
	{
		$provider = new DataProvider(DataProvider::HERO);
		$expected = 'heroesdata' . DIRECTORY_SEPARATOR . $provider->getPatch() . DIRECTORY_SEPARATOR . 'data';

		$result = $provider->getDirectory();

		$this->assertStringContainsString($expected, $result);
	}

	public function testConstructorLoadsData()
	{
		$provider = new DataProvider(DataProvider::HERO);

		$result = $provider->Abathur;
		$this->assertIsObject($result);

		$result = $provider->Abathur->unitId;
		$this->assertEquals('HeroAbathur', $result);
	}
}
