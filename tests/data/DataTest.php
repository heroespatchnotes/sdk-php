<?php

use Tatter\Heroes\Locator;
use Tests\Support\TestCase;

class DataTest extends TestCase
{
	public function testHasRepoData()
	{
		$path = HOMEPATH . 'vendor/heroestoolchest/heroes-data/heroesdata/2.47.2.76003/.hdp.json';
		$this->assertFileExists($path);

		$result = json_decode(file_get_contents($path), true);
		$this->assertIsArray($result);
		$this->assertArrayHasKey('hdp', $result);
	}

	public function testLocatorReturnsPath()
	{
		$expected = HOMEPATH . 'vendor/heroestoolchest/';
		$expected = realpath($expected) ?: $expected;
		$expected = rtrim($expected, '/') . DIRECTORY_SEPARATOR;

		$result = Locator::getPath();

		$this->assertEquals($expected, $result);
	}
}
