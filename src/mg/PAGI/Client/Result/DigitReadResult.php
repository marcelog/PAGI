<?php
/**
 * This decorated result adds the functionality to check for user input.
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

use PAGI\Exception\ChannelDownException;

class DigitReadResult extends ResultDecorator
{
    private $_digits;
    private $_timeout;

    public function isTimeout()
    {
        return $this->_timeout;
    }

    public function getDigits()
    {
        return $this->_digits;
    }

    public function __construct(IResult $result)
    {
        parent::__construct($result);
        $this->_digit = false;
        $this->_interrupted = false;
        $this->_timeout = false;
        $result = $result->getResult();
        switch($result)
        {
        case -1:
            throw new ChannelDownException();
            break;
        case 0:
            $this->_timeout = true;
            break;
        default:
            $this->_digits = chr($result);
            break;
        }
    }
}