<?php
/**
 * Tests bootstrap.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @author Marcelo Gornstein <marcelog@gmail.com>
 * @copyright 2015 Marcelo Gornstein
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . "/.."));
}
if (!defined('RESOURCES_DIR')) {
    define('RESOURCES_DIR', ROOT_PATH . '/resources');
}
if (!defined('TMPDIR')) {
    define('TMPDIR', '/tmp');
}
require_once implode(DIRECTORY_SEPARATOR, array(
  __DIR__, "..", "..", "vendor", "autoload.php"
));
