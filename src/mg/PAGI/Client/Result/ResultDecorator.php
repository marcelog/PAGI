<?php
/**
 * A result decorator.
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
 * A result decorator.
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
abstract class ResultDecorator implements IResult
{
    /**
     * Our decorated result.
     * @var IResult
     */
    private $_result;

    /**
     * Returns original line.
     *
     * @return string
     */
    public function getOriginalLine()
    {
        return $this->_result->getOriginalLine();
    }

    /**
     * Returns the integer value of the code returned by agi.
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->_result->getCode();
    }

    /**
     * Returns result (result=xxx) from the result.
     *
     * @return integer
     */
    public function getResult()
    {
        return $this->_result->getResult();
    }

    /**
     * Compares result to a given value.
     *
     * @param string $value Value to match against.
     *
     * @return boolean
     */
    public function isResult($value)
    {
        return $this->_result->isResult($value);
    }

    /**
     * Returns true if this command returned any data.
     *
     * @return boolean
     */
    public function hasData()
    {
        return $this->_result->hasData();
    }

    /**
     * Returns data, if any. False if none.
     *
     * @return string
     */
    public function getData()
    {
        return $this->_result->getData();
    }

    /**
     * Constructor.
     *
     * @param IResult $result Result to decorate.
     *
     * @return void
     */
    public function __construct(IResult $result)
    {
        $this->_result = $result;
    }
}