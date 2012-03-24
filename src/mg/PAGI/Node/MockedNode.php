<?php
/**
 * A Mocked node. Useful for testing ivr applications.
 *
 * PHP Version 5.3
 *
 * @category PAGI
 * @package  Node
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/PAGI/
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
namespace PAGI\Node;

use PAGI\Exception\MockedException;
/**
 * A Mocked node. Useful for testing ivr applications.
 *
 * @category PAGI
 * @package  Node
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
class MockedNode extends Node
{
    /**
     * The complete input digit chain for this node.
     * @var string
     */
    private $mockedInput = array();
    /**
     * The expected number of times that prompt messages need to be played
     * (keys are filenames).
     * @var string[]
     */
    private $expectedSaySound = array();
    /**
     * The counter of prompt messages actually played (keys are filenames).
     * @var string[]
     */
    private $doneSaySound = array();
    /**
     * Default expected state.
     * @var integer
     */
    private $expectedState = Node::STATE_NOT_RUN;

    /**
     * Configures this node to expect a given filename to be played n number
     * of times.
     *
     * @param string $filename
     * @param integer $totalTimes
     *
     * @return MockedNode
     */
    public function assertSaySound($filename, $totalTimes)
    {
        $this->expectedSaySound[$filename] = $totalTimes;
        $this->doneSaySound[$filename] = 0;
        return $this;
    }


    /**
     * Assert that this node is in state cancel after run().
     *
     * @return MockedNode
     */
    public function assertCancelled()
    {
        $this->expectedState = Node::STATE_CANCEL;
        return $this;
    }

    /**
     * Assert that this node is in state complete after run().
     *
     * @return MockedNode
     */
    public function assertComplete()
    {
        $this->expectedState = Node::STATE_COMPLETE;
        return $this;
    }

    /**
     * Assert that this node is in state of max input attempts reached
     * after run().
     *
     * @return MockedNode
     */
    public function assertMaxInputAttemptsReached()
    {
        $this->expectedState = Node::STATE_MAX_INPUTS_REACHED;
        return $this;
    }

    /**
     * Configure this node to mimic these digits as user input.
     *
     * @param string $digits
     *
     * @return MockedNode
     */
    public function runWithInput($digits)
    {
        preg_match_all('/([0-9*# X])/', $digits, $matches);
        $this->mockedInput = $matches[1];
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Node.Node::run()
     */
    public function run()
    {
        $result = parent::run();
        foreach ($this->expectedSaySound as $filename => $times) {
            $playedTimes = isset($this->doneSaySound[$filename])
                ? $this->doneSaySound[$filename]
                : 0
            ;
            if ($times != $playedTimes) {
                throw new MockedException(
                	"$filename expected to be played $times times, was "
                    . "played $playedTimes times"
                );
            }
        }
        if ($this->expectedState != Node::STATE_NOT_RUN) {
            if ($this->expectedState != $this->state) {
                throw new MockedException(
                    "Expected state: " . parent::stateToString($this->expectedState)
                    . " vs. Current: " . parent::stateToString($this->state)
                );
            }
        }
        return $result;
    }

    /**
     * Used to mimic the user input per prompt message.
     *
     * @param string $what
     * @param array $arguments
     *
     * @return void
     */
    protected function sayInterruptable($what, array $arguments)
    {
        $client = $this->getClient();
        $logger = $client->getLogger();
        $args = "(" . implode(',', $arguments) . ")";
        if (empty($this->mockedInput)) {
            $logger->debug("No more input available");
            $client->onStreamFile(false);
        } else {
            if ($arguments[1] != Node::DTMF_NONE) {
                $digit = array_shift($this->mockedInput);
                if (strpos($arguments[1], $digit) !== false) {
                    $logger->debug("Digit '$digit' will interrupt $what $args)");
                    $client->onStreamFile(true, $digit);
                } else {
                    if ($digit != ' ') {
                        $logger->warn("Digit '$digit' will not interrupt $what $args)");
                    } else {
                        $logger->warn("Timeout input for $what $args");
                    }
                    $client->onStreamFile(false);
                }
            } else {
                $logger->debug('None interruptable message');
                $client->onStreamFile(false);
            }
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Node.Node::callClientMethods()
     */
    protected function callClientMethods($methods, $stopWhen = null)
    {
        $client = $this->getClient();
        $logger = $client->getLogger();
        foreach ($methods as $callInfo) {
            foreach ($callInfo as $name => $arguments) {
                switch($name)
                {
                    case 'streamFile':
                        if (!isset($this->doneSaySound[$arguments[0]])) {
                            $this->doneSaySound[$arguments[0]] = 0;
                        }
                        $this->doneSaySound[$arguments[0]]++;
                    case 'sayNumber':
                    case 'sayDigits':
                    case 'sayDateTime':
                        $this->sayInterruptable($name, $arguments);
                        break;
                    case 'waitDigit':
                        if (empty($this->mockedInput)) {
                            $client->onWaitDigit(false);
                        } else {
                            $digit = array_shift($this->mockedInput);
                            if ($digit == ' ') {
                                $client->onWaitDigit(false);
                            } else {
                                $client->onWaitDigit(true, $digit);
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        return parent::callClientMethods($methods, $stopWhen);
    }
}