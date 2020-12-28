<?php

declare(strict_types=1);

namespace Heroes;

/**
 * Gamestring Class
 *
 * A string wrapper to handle special characters
 * and tags in data from StringProviders.
 * All "with" methods must be idempotent.
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
		'<n>',
		'<s>',
		'<img>',
	];

	/**
	 * @var string
	 */
	private $content;

	/**
	 * Level to apply for scaling, e.g.
	 * "Fires a laser that deals 296 damage"
	 *
	 * @var int|null
	 */
	private $level;

	/**
	 * Whether to include scaling info, e.g.
	 * "Fires a laser that deals 200 (+4% per level) damage"
	 *
	 * @var bool
	 */
	private $scaling;

	/**
	 * Stores the string
	 *
	 * @param string $content
	 */
	public function __construct(string $content)
	{
		$this->content = $content;
	}

	//--------------------------------------------------------------------

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
		return $this->content;
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
	 * Removes all tags, leaving their interior content.
	 *
	 * @return self
	 */
	public function withoutTags(): self
	{
		return new self(strip_tags($this->content));
	}

	/**
	 * Removes color tags leaving the content, e.g.
	 * <c val=\"bfd4fd\">0.75</c>
	 *
	 * @param string $format The format to use
	 *
	 * @return self
	 */
	public function withoutColor(): self
	{
		return $this->withouTag('<c>');
	}
}
