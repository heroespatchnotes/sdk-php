<?php

declare(strict_types=1);

namespace Tatter\Heroes\Providers;

use Tatter\Heroes\Interfaces\ProviderInterface;
use Tatter\Heroes\Locator;
use JsonException;
use RuntimeException;
use Traversable;

/**
 * Base Provider Abstract Class
 *
 * Common methods for dealing with provider
 * sources.
 */
abstract class BaseProvider implements ProviderInterface
{
	/**
	 * Array of shared instances, stored by
	 * a hash of patch and group
	 *
	 * @var array<string,ProviderInterface>
	 */
	private static $instances;

	//--------------------------------------------------------------------

	/**
	 * @var string
	 */
	private $group;

	/**
	 * @var string
	 */
	private $patch;

	/**
	 * Parsed metadata from .hdp.json
	 *
	 * @var object
	 */
	private $metaData;

	/**
	 * Path to the de-duplicated source file
	 *
	 * @var string|null
	 */
	protected $source;

	/**
	 * The source file contents.
	 *
	 * @var object
	 */
	protected $contents;

	//--------------------------------------------------------------------

	/**
	 * Returns a new/shared instance.
	 *
	 * @param string $group      The group
	 * @param string|null $patch The patch version, or null to use latest
	 *
	 * @return ProviderInterface
	 */
	protected static function get(string $group, string $patch = null): ProviderInterface
	{
		$patch = $patch ?? Locator::getLatest();
		$hash  = $group . '_' . $patch;

		if (! isset(self::$instances[$hash]))
		{
			self::$instances[$hash] = new static($group, $patch);
		}

		return self::$instances[$hash];
	}

	//--------------------------------------------------------------------
	
	/**
	 * Stores the group and patch and loads the contents.
	 *
	 * @param string $group The group
	 * @param string $patch The patch version
	 *
	 * @throws RuntimeException For missing file
	 * @throws JsonException    For invalid file
	 */
	private function __construct(string $group, string $patch)
	{
		$this->setPatch($patch ?? Locator::getLatest());
		$this->group = $group;

		$this->contents = json_decode(file_get_contents($this->getSource()), false, JSON_THROW_ON_ERROR);
	}

	//--------------------------------------------------------------------
	
	/**
	 * Verifies and stores a patch version.
	 *
	 * @param string $patch The patch version
	 *
	 * @throws RuntimeException For missing patch directory
	 * @throws JsonException    For invalid metadata file
	 */
	protected function setPatch(string $patch)
	{
		$directory = Locator::getPatchPath($patch);

		// Verify the HDP file
		if (! is_file($directory . '.hdp.json'))
		{
			throw new RuntimeException('Unable to locate metadata for patch ' . $patch);
		}

		$this->metaData = json_decode(file_get_contents($directory . '.hdp.json'), false, JSON_THROW_ON_ERROR);
		$this->patch    = $patch;
	}

	//--------------------------------------------------------------------

	/**
	 * Returns the pattern used to locate the source file with its directory.
	 *
	 * @return string
	 */
	abstract protected function getPattern(): string;

	/**
	 * Returns the de-duplicated source file.
	 *
	 * @return string
	 *
	 * @throws RuntimeException For file not found
	 */
	public function getSource(): string
	{
		if (is_null($this->source))
		{
			$pattern = $this->getPattern();

			// Match the correct source file
			$files = glob($pattern);
			$file  = reset($files);
			if (! $file || ! is_file($file))
			{
				throw new RuntimeException('Source file missing: ' . $pattern);			
			}

			$this->source = $file;
		}

		return $this->source;
	}
	
	/**
	 * Returns the group.
	 *
	 * @return string
	 */
	public function getGroup(): string
	{
		return $this->group;
	}
	
	/**
	 * Returns this provider's patch version.
	 *
	 * @return string
	 */
	public function getPatch(): string
	{
		return $this->patch;
	}
	
	/**
	 * Returns this provider's patch version.
	 *
	 * @return object
	 */
	public function getMetaData(): object
	{
		return $this->metaData;
	}

	/**
	 * Returns raw data.
	 *
	 * @return object
	 */
	public function getContents(): object
	{
		return $this->contents;
	}

	/**
	 * Returns the data as an iterator.
	 *
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return $this->contents;
	}

	//--------------------------------------------------------------------
	// Magic Data Accessors
	//--------------------------------------------------------------------

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get(string $name)
	{
		return $this->contents->$name;
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function __isset(string $name): bool
	{
		return property_exists($this->contents, $name);
	}
}
