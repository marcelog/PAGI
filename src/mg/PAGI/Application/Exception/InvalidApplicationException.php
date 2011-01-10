<?php
/**
 * This exception indicates the launcher was invoked with an invalid application.
 * Maybe the class is not loaded, or lacks needed methods.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Exception
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\Application\Exception;

use PAGI\Exception\PAGIException;

/**
 * This exception indicates the launcher was invoked with an invalid application.
 * Maybe the class is not loaded, or lacks needed methods.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Exception
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
class InvalidApplicationException extends PAGIException
{
}
