<?php namespace Tests\Support;

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * PHPunit test case.
 */
abstract class TestCase extends BaseTestCase
{
	/**
	 * Default patch for non-specific tests.
	 *
	 * @var string
	 */
	protected $patch = '2.47.2.76003';
}
