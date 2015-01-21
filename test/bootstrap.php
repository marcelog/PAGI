<?php
ini_set(
    'include_path',
    implode(
        PATH_SEPARATOR,
        array(
            realpath(implode(
                DIRECTORY_SEPARATOR, array(__DIR__, '..', 'src', 'mg')
            )),
            ini_get('include_path'),
        )
    )
);
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . "/.."));
}
if (!defined('RESOURCES_DIR')) {
    define('RESOURCES_DIR', ROOT_PATH . '/resources');
}
if (!defined('TMPDIR')) {
    define('TMPDIR', getenv('TMPDIR'));
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'PAGI/Autoloader/Autoloader.php'; // Include PAGI autoloader.
\PAGI\Autoloader\Autoloader::register(); // Call autoloader register for PAGI autoloader.
