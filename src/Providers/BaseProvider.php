<?php

declare(strict_types=1);

namespace Tatter\Heroes\Providers;

use Tatter\Heroes\Interfaces\ProviderInterface;
use Tatter\Heroes\Locator;
use JsonException;
use RuntimeException;

/**
 * Base Provider Abstract Class
 *
 * Common methods for dealing with provider
 * sources.
 */
abstract class BaseProvider implements ProviderInterface
{
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
	 * Path to the deduplicated source file
	 *
	 * @var string
	 */
	protected $source;

	/**
	 * The loaded data.
	 *
	 * @var object
	 */
	protected $data;

	//--------------------------------------------------------------------

	/**
	 * Returns the de-duplicated source directory.
	 *
	 * @return string
	 *
	 * @throws RuntimeException For missing directory
	 */
	abstract protected function getDirectory(): string;

	//--------------------------------------------------------------------

	/**
	 * Sets the patch.
	 *
	 * @param string $patch|null The patch version, or null to use latest
	 */
	public function __construct(string $patch = null)
	{
		$this->setPatch($patch ?? Locator::getLatest());
	}
	
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
	 * Returns the path to the source file.
	 *
	 * @return string
	 */
	public function getSource(): string
	{
		return $this->source;
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
		return $this->data->$name;
	}

	/**
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function __isset(string $name): bool
	{
		return property_exists($this->data, $name);
	}
}
