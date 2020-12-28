<?php

use Heroes\Gamestring;
use Tests\Support\TestCase;

class GamestringTest extends TestCase
{
	public function testToString()
	{
		$content = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';

		$gamestring = new Gamestring($content);

		$this->assertEquals($content, (string) $gamestring);
	}

	public function testWithScalingDefault()
	{
		$content  = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';
		$expected = 'string <c val=\"bfd4fd\">350 (+4% per level)</c>';

		$gamestring = (new Gamestring($content))->withScaling();

		$this->assertEquals($expected, (string) $gamestring);
	}

	public function testWithScalingMultiple()
	{
		$content  = 'string <c val=\"bfd4fd\">350~~0.04~~</c> <c val=\"bfd4fd\">150~~0.05~~</c>';
		$expected = 'string <c val=\"bfd4fd\">350 (+4% per level)</c> <c val=\"bfd4fd\">150 (+5% per level)</c>';

		$gamestring = (new Gamestring($content))->withScaling();

		$this->assertEquals($expected, (string) $gamestring);
	}

	public function testWithScalingWithFormat()
	{
		$content  = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';
		$expected = 'string <c val=\"bfd4fd\">350+4%</c>';

		$gamestring = (new Gamestring($content))->withScaling('+%g%%');

		$this->assertEquals($expected, (string) $gamestring);
	}

	/**
	 * @dataProvider levelProvider
	 */
	public function testWithLevel($level, $scaled)
	{
		$content  = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';
		$expected = 'string <c val=\"bfd4fd\">' . $scaled . '</c>';

		$gamestring = (new Gamestring($content))->withLevel($level);

		$this->assertEquals($expected, (string) $gamestring);
	}

	public function levelProvider()
	{
		return [
			[0, 350],
			[1, 364],
			[2, 379],
			[10, 518],
			[16, 656],
			[20, 767],
			[30, 1135],
		];
	}

	public function testWithoutTag()
	{
		$content  = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';
		$expected = 'string 350~~0.04~~';

		$gamestring = (new Gamestring($content))->withoutTag('<c>');

		$this->assertEquals($expected, (string) $gamestring);
	}

	public function testWithoutTagUnmatched()
	{
		$content  = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';
		$expected = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';

		$gamestring = (new Gamestring($content))->withoutTag('<x>');

		$this->assertEquals($expected, (string) $gamestring);
	}

	public function testWithoutColor()
	{
		$content  = 'string <c val=\"bfd4fd\">350~~0.04~~</c>';
		$expected = 'string 350~~0.04~~';

		$gamestring = (new Gamestring($content))->withoutTag('<c>');

		$this->assertEquals($expected, (string) $gamestring);
	}

	public function testWithoutTags()
	{
		$content  = 'string<n/><n/><c val=\"bfd4fd\">350~~0.04~~</c>';
		$expected = 'string350~~0.04~~';

		$gamestring = (new Gamestring($content))->withoutTags();

		$this->assertEquals($expected, (string) $gamestring);
	}
}
