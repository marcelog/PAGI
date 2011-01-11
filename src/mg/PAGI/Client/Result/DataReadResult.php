<?php
/**
 * This decorated result adds the functionality to check for user input (more
 * than one digit).
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

class DataReadResult extends DigitReadResult
{
    private $_digits;

    public function getDigits()
    {
        return $this->_digits;
    }

    public function __construct(IResult $result)
    {
        parent::__construct($result);
        $this->_digits = $result->getResult();
    }
}