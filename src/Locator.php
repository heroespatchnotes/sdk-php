<?php

declare(strict_types=1);

namespace Heroes;

use Composer\Autoload\ClassLoader;
use DirectoryIterator;
use ReflectionClass;
use RuntimeException;

/**
 * Locator Class
 *
 * Locates repository data dynamically from
 * Composer's own directory structure.
 */
final class Locator
{
	/**
	 * Store for the located path
	 *
	 * @var string|null
	 */
	private static $path;

	/**
	 * Array of available patch versions
	 *
	 * @var string[]|null
	 */
	private static $patches;

	/**
	 * Returns the path to the Heroes Tool Chest
	 * organization in vendor.
	 *
	 * @return string
	 *
	 * @throws RuntimeException For missing directory
	 */
	public static function getPath(): string
	{
		if (is_null(self::$path))
		{
			$reflection = new ReflectionClass(ClassLoader::class);
			$vendor     = dirname($reflection->getFileName(), 2);

			$path = $vendor . DIRECTORY_SEPARATOR . 'heroestoolchest';
			if (! is_dir($path))
			{
				throw new RuntimeException('Unable to locate HeroesToolChest.');
			}

			$path = rtrim(realpath($path) ?: $path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

			self::$path = $path;
		}

		return self::$path;
	}

	/**
	 * Returns all discovered patch version directories.
	 *
	 * @return string[]
	 */
	public static function getPatches(): array
	{
		if (is_null(self::$patches))
		{
			$patches = [];

			$directory = self::getPath() . 'heroes-data/heroesdata/';
			foreach (new DirectoryIterator($directory) as $fileinfo)
			{
				if ($fileinfo->getType() === 'dir' && ! $fileinfo->isDot())
				{
					$patches[] = $fileinfo->getBasename();
				}
			}
			usort($patches, 'version_compare');

			self::$patches = $patches;
		}

		return self::$patches;
	}

	/**
	 * Returns the latest patch.
	 *
	 * @return string
	 *
	 * @throws RuntimeException If not patches are were discovered
	 */
	public static function getLatest(): string
	{
		if (! $patches = self::getPatches())
		{
			throw new RuntimeException('No patches discovered.');
		}

		return end($patches);
	}

	/**
	 * Returns the path to a specific patch.
	 *
	 * @param string $patch
	 *
	 * @return string
	 *
	 * @throws RuntimeException For missing directory
	 */
	public static function getPatchPath(string $patch): string
	{
		$directory = self::getPath()
			. 'heroes-data' . DIRECTORY_SEPARATOR
			. 'heroesdata' . DIRECTORY_SEPARATOR
			. $patch . DIRECTORY_SEPARATOR;

		if (! is_dir($directory))
		{
			throw new RuntimeException('Unable to locate directory for patch ' . $patch);	
		}

		return self::normalizeDirectory($directory);
	}

	//--------------------------------------------------------------------
	// Utility
	//--------------------------------------------------------------------

	/**
	 * Converts a directory to its realpath with trailing separator.
	 *
	 * @param string $directory
	 *
	 * @return string
	 */
	public static function normalizeDirectory(string $directory): string
	{
		return rtrim(realpath($directory) ?: $directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	}

	/**
	 * Gets the shorthand patch reference
	 * E.g. 83086 from 2.53.0.83086
	 *
	 * @param string $patch
	 *
	 * @return string
	 */
	public static function shortPatch(string $patch): string
	{
		// Ignore any PTR suffixes
		$patch = str_replace('_ptr', '', $patch);
		$parts = explode('.', $patch);

		return end($parts);
	}
}
