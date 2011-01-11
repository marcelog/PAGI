<?php
/**
 * This class parses and encapsulates the result from an agi command. You must
 * instantiate it with the result line as came from asterisk.
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
namespace PAGI\Client;

/**
 * This class parses and encapsulates the result from an agi command. You must
 * instantiate it with the result line as came from asterisk.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
class Result
{
    /**
     * Result code (3 digits).
     * @var integer
     */
    private $_code;

    /**
     * Result string (if any), from result=xxxxx string.
     * @var string
     */
    private $_result;

    /**
     * Result data (if any).
     * @var string
     */
    private $_data;

    /**
     * AGI result line (i.e: xxx result=zzzzzz [yyyyyy])
     * @var string
     */
    private $_line;

    /**
     * Returns original line.
     *
     * @return string
     */
    public function getOriginalLine()
    {
        return $this->_line;
    }

    /**
     * Returns the integer value of the code returned by agi.
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Returns result (result=xxx) from the result.
     *
     * @return integer
     */
    public function getResult()
    {
        return $this->_result;
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
        return $this->_result == $value;
    }

    /**
     * Returns true if this command returned any data.
     *
     * @return boolean
     */
    public function hasData()
    {
        return $this->_data !== false;
    }

    /**
     * Returns data, if any. False if none.
     *
     * @return string
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Standard.
     *
     * @return string
     */
    public function __toString()
    {
        return
            '[ Result for |' . $this->getOriginalLine() . '|'
            . ' code: |' . $this->getCode() . '|'
            . ' result: |' . $this->getResult() . '|'
            . ' data: |' . $this->getData() . '|'
            . ']'
        ;
    }

    /**
     * Constructor. Will parse the data that came from agi.
     *
     * @param string $line Result literal as came from agi.
     *
     * @return void
     */
    public function __construct($line)
    {
        $this->_line = $line;
        $this->_result = false;
        $this->_data = false;

        $response = explode(' ', $line);
        $this->_code = $response[0];

        $this->_result = explode('=', $response[1]);
        if (isset($this->_result[1])) {
            $this->_result = $this->_result[1];
        }

        if (isset($response[2])) {
            unset($response[0]);
            unset($response[1]);
            $this->_data = implode(' ', $response);
        }
    }
}