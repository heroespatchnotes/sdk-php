<?php

use Heroes\Locator;
use Tests\Support\TestCase;

class DataTest extends TestCase
{
	/**
	 * Runs a raw sanity check to ensure proper installation
	 */
	public function testHasRepoData()
	{
		$path = HOMEPATH . 'vendor/heroestoolchest/heroes-data/heroesdata/2.47.2.76003/.hdp.json';
		$this->assertFileExists($path);

		$result = json_decode(file_get_contents($path), true);
		$this->assertIsArray($result);
		$this->assertArrayHasKey('hdp', $result);
	}

	public function testNormalizeValidDirectory()
	{
		$expected = HOMEPATH . 'src';
		$expected = realpath($expected) ?: $expected;
		$expected = rtrim($expected, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		$result = Locator::normalizeDirectory(HOMEPATH . 'src');

		$this->assertEquals($expected, $result);
	}

	public function testNormalizeInvalidDirectory()
	{
		$path   = '/foobar/bimbam/boo';
		$result = Locator::normalizeDirectory($path);

		$this->assertEquals($path . DIRECTORY_SEPARATOR, $result);
	}

	public function testShortPatch()
	{
		$this->assertEquals('76003', Locator::shortPatch('2.47.2.76003'));
		$this->assertEquals('76268', Locator::shortPatch('2.48.0.76268_ptr'));
	}

	public function testReturnsPath()
	{
		$expected = Locator::normalizeDirectory(HOMEPATH . 'vendor/heroestoolchest');

		$result = Locator::getPath();

		$this->assertEquals($expected, $result);
	}

	public function testReturnsPatches()
	{
		$result = Locator::getPatches();

		$this->assertIsArray($result);
		$this->assertContains('2.47.2.76003', $result);
	}

	public function testReturnsPatchesOrdered()
	{
		$current = '1.0.0.00000';

		foreach (Locator::getPatches() as $patch)
		{
			$this->assertTrue(version_compare($current, $patch, '<'));

			$current = $patch;
		}
	}

	public function testReturnsLatest()
	{
		$patches  = Locator::getPatches();
		$expected = end($patches);

		$result = Locator::getLatest();

		$this->assertEquals($expected, $result);
	}

	public function testReturnsPatchPath()
	{
		$patch    = '2.47.2.76003';
		$expected = Locator::normalizeDirectory(HOMEPATH . 'vendor/heroestoolchest/heroes-data/heroesdata/' . $patch);

		$result = Locator::getPatchPath($patch);

		$this->assertEquals($expected, $result);
	}

	public function testThrowsInvalidPatchPath()
	{
		$patch = '1.23.4.56789';

		$this->expectException('RuntimeException');
		$this->expectExceptionMessage('Unable to locate directory for patch ' . $patch);

		Locator::getPatchPath($patch);
	}
}
