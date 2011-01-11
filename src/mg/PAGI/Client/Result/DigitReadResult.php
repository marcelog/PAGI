<?php
/**
 * This decorated result adds the functionality to check for user input. We
 * need a distinction between a single digit read (this class) and a data read
 * (DataReadResult) because asterisk sends the ascii number for the character
 * read (the first case) and the literal string in the latter.
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

use PAGI\Exception\ChannelDownException;

/**
 * This decorated result adds the functionality to check for user input. We
 * need a distinction between a single digit read (this class) and a data read
 * (DataReadResult) because asterisk sends the ascii number for the character
 * read (the first case) and the literal string in the latter.
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
class DigitReadResult extends ResultDecorator implements IReadResult
{
    /**
     * Digits read (if any).
     * @var string
     */
    private $_digits;

    /**
     * Timeout?
     * @var boolean
     */
    private $_timeout;

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IReadResult::isTimeout()
     */
    public function isTimeout()
    {
        return $this->_timeout;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IReadResult::getDigits()
     */
    public function getDigits()
    {
        return $this->_digits;
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