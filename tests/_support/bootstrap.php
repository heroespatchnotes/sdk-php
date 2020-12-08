<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

defined('ENVIRONMENT') || define('ENVIRONMENT', 'testing');
defined('HOMEPATH') || define('HOMEPATH', __DIR__ . '/../../');

require HOMEPATH . 'vendor/autoload.php';
