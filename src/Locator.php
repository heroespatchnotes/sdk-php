<?php

declare(strict_types=1);

namespace Tatter\Heroes;

use Composer\Autoload\ClassLoader;
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
				throw new RuntimeException('Unable to locate HeroesToolChest');
			}

			$path = rtrim(realpath($path) ?: $path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

			self::$path = $path;
		}

		return self::$path;
	}
}
