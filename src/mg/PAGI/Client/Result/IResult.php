<?php
/**
 * This is an interface so we can decorate it later.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\Client\Result;

/**
 * This is an interface so we can decorate it later.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
interface IResult
{
	/**
     * Returns original line.
     *
     * @return string
     */
    public function getOriginalLine();

    /**
     * Returns the integer value of the code returned by agi.
     *
     * @return integer
     */
    public function getCode();

    /**
     * Returns result (result=xxx) from the result.
     *
     * @return integer
     */
    public function getResult();

    /**
     * Compares result to a given value.
     *
     * @param string $value Value to match against.
     *
     * @return boolean
     */
    public function isResult($value);

    /**
     * Returns true if this command returned any data.
     *
     * @return boolean
     */
    public function hasData();

    /**
     * Returns data, if any. False if none.
     *
     * @return string
     */
    public function getData();
}
