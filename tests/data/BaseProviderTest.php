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
		$this->provider = new DummyProvider();
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
		$expected = (object) [
			'hdp' => '4.5.0',
		];

		$this->provider->setPatch($this->patch);

		$this->assertEquals($expected, $this->provider->getMetaData());
	}
}
