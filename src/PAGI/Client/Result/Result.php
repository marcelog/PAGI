<?php
/**
 * This class parses and encapsulates the result from an agi command. You must
 * instantiate it with the result line as came from asterisk.
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

/**
 * This class parses and encapsulates the result from an agi command. You must
 * instantiate it with the result line as came from asterisk.
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
class Result implements IResult
{
    /**
     * Result code (3 digits).
     * @var integer
     */
    private $code;

    /**
     * Result string (if any), from result=xxxxx string.
     * @var string
     */
    private $result;

    /**
     * Result data (if any).
     * @var string
     */
    private $data;

    /**
     * AGI result line (i.e: xxx result=zzzzzz [yyyyyy])
     * @var string
     */
    private $line;

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IResult::getOriginalLine()
     */
    public function getOriginalLine()
    {
        return $this->line;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IResult::getCode()
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IResult::getResult()
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IResult::isResult()
     */
    public function isResult($value)
    {
        return $this->result == $value;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IResult::hasData()
     */
    public function hasData()
    {
        return $this->data !== false;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IResult::getData()
     */
    public function getData()
    {
        return $this->data;
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
            . ' result: |' . print_r($this->getResult(), true) . '|'
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
        $this->line = $line;
        $this->result = false;
        $this->data = false;

        $response = explode(' ', $line);
        $this->code = $response[0];

        $this->result = explode('=', $response[1]);
        if (isset($this->result[1])) {
            $this->result = $this->result[1];
        }

        if (isset($response[2])) {
            unset($response[0]);
            unset($response[1]);
            $this->data = implode(' ', $response);
        }
    }
}
