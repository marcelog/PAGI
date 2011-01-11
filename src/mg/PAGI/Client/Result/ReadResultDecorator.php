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
abstract class ReadResultDecorator implements IReadResult
{
    /**
     * Our decorated result.
     * @var IReadResult
     */
    private $_result;

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IResult::getOriginalLine()
     */
    public function getOriginalLine()
    {
        return $this->_result->getOriginalLine();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IResult::getCode()
     */
    public function getCode()
    {
        return $this->_result->getCode();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IResult::getResult()
     */
    public function getResult()
    {
        return $this->_result->getResult();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IResult::isResult()
     */
    public function isResult($value)
    {
        return $this->_result->isResult($value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IResult::hasData()
     */
    public function hasData()
    {
        return $this->_result->hasData();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IResult::getData()
     */
    public function getData()
    {
        return $this->_result->getData();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IReadResult::isTimeout()
     */
    public function isTimeout()
    {
        return $this->_result->isTimeout();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IReadResult::getDigits()
     */
    public function getDigits()
    {
        return $this->_result->getDigits();
    }

    /**
     * Constructor.
     *
     * @param IReadResult $result Result to decorate.
     *
     * @return void
     */
    public function __construct(IReadResult $result)
    {
        $this->_result = $result;
    }
}