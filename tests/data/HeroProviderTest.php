<?php

use Heroes\Providers\DataProvider;
use Tests\Support\TestCase;

class HeroProviderTest extends TestCase
{
	/**
	 * @var DataProvider
	 */
	private $provider;

	protected function setUp(): void
	{
		$this->provider = DataProvider::get(DataProvider::HERO);
	}

	public function testHasHeroes()
	{
		foreach (['Abathur', 'Alarak', 'Alexstrasza'] as $id)
		{
			$this->assertTrue(isset($this->provider->$id));
		}

		$this->assertFalse(isset($this->provider->Boogieman));
	}

	public function testKeysAreHeroIDs()
	{
		$result = array_keys((array) $this->provider->getContents());

		$this->assertContains('Zeratul', $result);
	}
}
