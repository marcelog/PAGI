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
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/PAGI/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
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
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class DigitReadResult extends ResultDecorator implements IReadResult
{
    /**
     * Digits read (if any).
     * @var string
     */
    protected $_digits;

    /**
     * Timeout?
     * @var boolean
     */
    protected $_timeout;

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
     * (non-PHPdoc)
     * @see PAGI\Client\Result.IReadResult::getDigitsCount()
     */
    public function getDigitsCount()
    {
        return strlen($this->_digits);
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
        $this->_digits = false;
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
            $this->_digits = chr(intval($result));
            break;
        }
    }
}