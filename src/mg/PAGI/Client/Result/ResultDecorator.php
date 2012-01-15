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
 * A result decorator.
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
abstract class ResultDecorator implements IResult
{
    /**
     * Our decorated result.
     * @var IResult
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
     * Standard procedure.
	 *
	 * @return string
     */
    public function __toString()
    {
        return $this->_result->__toString();
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