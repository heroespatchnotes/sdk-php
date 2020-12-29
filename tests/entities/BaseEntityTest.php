<?php

use Heroes\Entities\BaseEntity;
use Heroes\Gamestring;
use Tests\Support\TestCase;

class BaseEntityTest extends TestCase
{
	/**
	 * @var BaseEntity
	 */
	private $entity;

	protected function setUp(): void
	{
		$this->entity = new class extends BaseEntity {

			public function __construct()
			{
				$this->id      = 'test';
				$this->strings = [
					'string1' => new Gamestring('string one'),
					'string2' => new Gamestring('string two'),
				];
			}
		};
	}

	public function testId()
	{
		$this->assertEquals('test', $this->entity->id());
	}

	public function testString()
	{
		$result = $this->entity->string('string1');

		$this->assertInstanceOf(Gamestring::class, $result);
		$this->assertEquals('string one', (string) $result);
	}

	public function testStringThrowsOnMissingKey()
	{
		$this->expectException('RuntimeException');
		$this->expectExceptionMessage('String not found for string3');

		$result = $this->entity->string('string3');
	}

	public function testStrings()
	{
		$result = $this->entity->strings();

		$this->assertIsArray($result);
		$this->assertInstanceOf(Gamestring::class, $result['string2']);
		$this->assertEquals('string two', (string) $result['string2']);
	}
}
