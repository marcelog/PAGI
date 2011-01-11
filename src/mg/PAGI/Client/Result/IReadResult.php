<?php
/**
 * Interface for a read result, so it can be decorated later.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Result
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
namespace PAGI\Client\Result;

/**
 * Interface for a read result, so it can be decorated later.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Result
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
interface IReadResult extends IResult
{
    /**
     * True if the operation completed and no input was received from the user.
     *
     * @return boolean
     */
    public function isTimeout();

    /**
     * Returns digits read. False if none.
     *
     * @return string
     */
    public function getDigits();
}