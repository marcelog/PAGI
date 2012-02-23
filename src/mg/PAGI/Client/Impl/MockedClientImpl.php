<?php
/**
 * An AGI client implementation useful for mocking and testing ivr apps.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
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
namespace PAGI\Client\Impl;

use PAGI\Client\AbstractClient;

/**
 * An AGI client implementation useful for mocking and testing ivr apps.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class MockedClientImpl extends AbstractClient
{
    /**
     * Mocked result strings.
     * @var string[]
     */
    private $mockedResultStrings;

    /**
     * Result counter.
     * @var integer
     */
    private $resultCounter = -1;


    protected function send($text)
    {
        $this->resultCounter++;
        return $this->getResultFromResultString($this->mockedResultStrings[$this->resultCounter]);
    }

    protected function open()
    {
        return;
    }

    protected function close()
    {
        return;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function __construct(
        array $envVariables = array(), array $resultStrings = array()
    ) {
        $this->_variables = $envVariables;
        $this->mockedResultStrings = $resultStrings;
        $this->open();
    }
}