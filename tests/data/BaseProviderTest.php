<?php

use Tests\Support\DummyProvider;
use Tests\Support\TestCase;

class BaseProviderTest extends TestCase
{
	/**
	 * @var DummyProvider
	 */
	private $provider;

	protected function setUp(): void
	{
		$this->provider = DummyProvider::get('test');
	}

	public function testSetPatchThrowsInvalidPatch()
	{
		$patch = '1.23.4.56789';

		$this->expectException('RuntimeException');
		$this->expectExceptionMessage('Unable to locate directory for patch ' . $patch);

		$this->provider->setPatch($patch);
	}

	public function testSetPatchSetsPatch()
	{
		$this->provider->setPatch($this->patch);

		$this->assertEquals($this->patch, $this->provider->getPatch());
	}

	public function testSetPatchSetsMetaData()
	{
		$this->provider->setPatch($this->patch);

		$metaData = $this->provider->getMetaData();

		$this->assertIsObject($metaData);
		$this->assertObjectHasAttribute('hdp', $metaData);
	}
}
