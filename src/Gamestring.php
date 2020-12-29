<?php

declare(strict_types=1);

namespace Heroes;

/**
 * Gamestring Class
 *
 * A string wrapper to handle special characters
 * and tags in data from StringProviders.
 * All "with/without" methods must be idempotent.
 */
final class Gamestring
{
	/**
	 * Array of all tags allowed in a
	 * formatted string, usually used
	 * subtractively with strip_tags().
	 */
	const ALLOWED_TAGS = [
		'<c>',
		'<s>',
		'<n>',
		'<img>',
	];

	/**
	 * @var string
	 */
	private $content;

	//--------------------------------------------------------------------

	/**
	 * Replaces color tags with their HTML equivalent.
	 *
	 * @param string $contents
	 *
	 * @return string
	 */
	public static function colorHtml(string $string): string
	{
		// Convert <s> tags the same
		$string = str_replace('<s', '<c', $string);

		$string = preg_replace_callback('/<c val="[[:xdigit:]]+"/', function ($matches) {
			$parts  = explode('=', $matches[0]);
			$result = str_replace('c val', 'span', $parts[0]);

			$result .= ' style="color: #';
			$result .= ltrim($parts[1], '"');

			return $result;
		}, $string);

		return str_replace(['</c>', '</s>'], '</span>', $string);
	}

	/**
	 * Replaces image tags with an approximate Unicode equivalent.
	 *
	 * @param string $contents
	 *
	 * @return string
	 */
	public static function imageHtml(string $string): string
	{
		$string = preg_replace_callback('/<img path="@UI\/[A-Za-z]+".*?>/', function ($matches) {
			$parts = explode('"', $matches[0]);
			$parts = explode('/', $parts[1]);

			switch ($parts[1])
			{
				case 'StormTalentInTextQuestIcon':
					return "\u{2757}";
				case 'StormTalentInTextArmorIcon':
					return "\u{1F6E1}";
			}

			return $parts[1];
		}, $string);

		return str_replace(['</c>', '</s>'], '</span>', $string);
	}

	//--------------------------------------------------------------------

	/**
	 * Stores the string
	 *
	 * @param string $content
	 */
	public function __construct(string $content)
	{
		$this->content = $content;
	}

	/**
	 * Returns the content directly.
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->asRaw();
	}

	/**
	 * Returns the content directly.
	 *
	 * @return string
	 */
	public function asRaw(): string
	{
		return $this->content;
	}

	/**
	 * Returns the content formatted for HTML display.
	 *
	 * @return string
	 */
	public function asHtml(): string
	{
		$string = $this->withoutNewline('<br>')->asRaw();
		$string = self::colorHtml($string);
		$string = self::imageHtml($string);
		$string = str_replace('name=', 'class=', $string);

		return $string;
	}

	/**
	 * Returns the content formatted for terminal display.
	 *
	 * @return string
	 */
	public function asCli(): string
	{
		return $this->content;
	}

	//--------------------------------------------------------------------

	/**
	 * Returns a new Gamestring at the given level.
	 * Scaled = damage * (scaling ^ level)
	 *
	 * @return self
	 */
	public function withLevel(int $level): self
	{
		$content = preg_replace_callback('/[0-9]+~~[0-9.]+~~/', function ($matches) use ($level) {
			$parts = explode('~~', $matches[0]);
			$base  = floatval($parts[0]);
			$scale = floatval($parts[1]);

			return round($base * pow(1 + $scale, $level));
		}, $this->content);

		return new self($content);
	}

	/**
	 * Returns the content with scaling info.
	 *
	 * @param string $format The format to use
	 *
	 * @return self
	 */
	public function withScaling(string $format = ' (%+g%% per level)'): self
	{
		$content = preg_replace_callback('/~~[0-9.]+~~/', function ($matches) use ($format) {
			$num = floatval(trim($matches[0], '~')) * 100;
			return sprintf($format, $num);
		}, $this->content);

		return new self($content);
	}

	//--------------------------------------------------------------------

	/**
	 * Removes all tags, leaving their interior content.
	 *
	 * @return self
	 */
	public function withoutTags(): self
	{
		return $this->withoutColor()
			->withoutImage()
			->withoutStandard()
			->withoutNewline();
	}

	/**
	 * Removes a specific tag, leaving its interior content.
	 *
	 * @param string $tag
	 *
	 * @return self
	 */
	public function withoutTag(string $tag): self
	{
		$allowed = implode(array_diff(self::ALLOWED_TAGS, [$tag]));
		$content = strip_tags($this->content, $allowed);

		return new self($content);
	}

	/**
	 * Removes color tags leaving the content, e.g.
	 * <c val="bfd4fd">0.75</c>
	 *
	 * @return self
	 */
	public function withoutColor(): self
	{
		return $this->withoutTag('<c>');
	}

	/**
	 * Removes image tags, e.g.
	 * <img path="@UI/StormTalentInTextArmorIcon" alignment="uppermiddle" color="BBBBBB" width="20" height="22"/>
	 *
	 * @return self
	 */
	public function withoutImage(): self
	{
		return $this->withoutTag('<img>');
	}

	/**
	 * Removes <s> tags leaving the content, e.g.
	 * <s val="bfd4fd" name="StandardTooltipDetails">Mana: 50</s>
	 *
	 * @return self
	 */
	public function withoutStandard(): self
	{
		return $this->withoutTag('<s>');
	}

	/**
	 * Removes newline tags, replacing them with $replace, e.g.
	 * Cooldown: 1 second<n/>Consumes all Combo Points
	 *
	 * @param string $replace String to use as a replacement
	 *
	 * @return self
	 */
	public function withoutNewline(string $replace = ' '): self
	{
		$content = str_replace('<n/>', $replace, $this->content);

		return new self($content);
	}
}
