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
     * (keys are pagi client method names).
     * @var string[]
     */
    private $expectedSay = array();

    /**
     * The counter of prompt messages actually played
     * (keys are pagi client method names).
     * @var string[]
     */
    private $doneSay = array();

    /**
     * Default expected state.
     * @var integer
     */
    private $expectedState = Node::STATE_NOT_RUN;

    /**
     * Optional callback to be used before executing the onInputValid callback.
     * @var Closure|null
     */
    private $validInputCallback = null;

    /**
     * Optional callback to be used before executing the onInputFailed callback.
     * @var Closure|null
     */
    private $failedInputCallback = null;

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
        return $this->assertSay('streamFile', $totalTimes, array($filename));
    }

    /**
     * Configures this node to expect the given digits to be played n number
     * of times.
     *
     * @param integer $digits
     * @param integer $totalTimes
     *
     * @return MockedNode
     */
    public function assertSayDigits($digits, $totalTimes)
    {
        return $this->assertSay('sayDigits', $totalTimes, array($digits));
    }

    /**
     * Configures this node to expect the given number to be played n number
     * of times.
     *
     * @param integer $digits
     * @param integer $totalTimes
     *
     * @return MockedNode
     */
    public function assertSayNumber($number, $totalTimes)
    {
        return $this->assertSay('sayNumber', $totalTimes, array($number));
    }

    /**
     * Configures this node to expect the given datetime to be played n number
     * of times with the given format.
     *
     * @param integer $digits
     * @param integer $totalTimes
     *
     * @return MockedNode
     */
    public function assertSayDateTime($time, $format, $totalTimes)
    {
        return $this->assertSay('sayDateTime', $totalTimes, array($time, $format));
    }

    /**
     * Records a played prompt message with its arguments.
     *
     * @param string $what The pagi method name called.
     * @param string[] $arguments The arguments used, without the interrupt
     * digits.
     *
     * @return void
     */
    protected function recordDoneSay($what, $arguments = array())
    {
        $semiHash = serialize(array($what, $arguments));
        if (isset($this->doneSay[$semiHash])) {
            $this->doneSay[$semiHash]++;
        } else {
            $this->doneSay[$semiHash] = 1;
        }
    }

    /**
     * Generic method to expect prompt messages played.
     *
     * @param string $what The pagi method name to expect.
     * @param integer $totalTimes Total times to expect this call
     * @param string[] $arguments The arguments to assert.
     *
     * @return MockedNode
     */
    protected function assertSay($what, $totalTimes, $arguments = array())
    {
        $semiHash = serialize(array($what, $arguments));
        $this->expectedSay[$semiHash] = $totalTimes;
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
        foreach ($this->expectedSay as $semiHash => $times) {
            $data = unserialize($semiHash);
            $what = array_shift($data);
            $arguments = array_shift($data);
            $doneTimes = 0;
            if (isset($this->doneSay[$semiHash])) {
                $doneTimes = $this->doneSay[$semiHash];
            }
            if ($times != $doneTimes) {
                throw new MockedException(
                    "$what (" . implode(",", $arguments) . ") expected to be"
                    . " called $times times, was called $doneTimes times"
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
        $argsCount = count($arguments);
        $interruptDigits = $arguments[$argsCount - 1];

        $this->recordDoneSay($what, array_slice($arguments, 0, $argsCount - 1));
        if (empty($this->mockedInput)) {
            $logger->debug("No more input available");
            $client->onStreamFile(false);
        } else {
            if ($interruptDigits != Node::DTMF_NONE) {
                $digit = array_shift($this->mockedInput);
                if (strpos($interruptDigits, $digit) !== false) {
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
        $result = null;
        foreach ($methods as $callInfo) {
            foreach ($callInfo as $name => $arguments) {
                switch($name)
                {
                    case 'streamFile':
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
                $result = parent::callClientMethod($name, $arguments);
                if ($stopWhen !== null) {
                    if ($stopWhen($result)) {
                        return $result;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Execute a callback before invoking the real callback for valid input.
     *
     * @param \Closure $callback
     *
     * @return \PAGI\Node\MockedNode
     */
    public function doBeforeValidInput(\Closure $callback)
    {
        $this->validInputCallback = $callback;
        return $this;
    }

    /**
     * Execute a callback before invoking the real callback for failed input.
     *
     * @param \Closure $callback
     *
     * @return \PAGI\Node\MockedNode
     */
    public function doBeforeFailedInput(\Closure $callback)
    {
        $this->failedInputCallback = $callback;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Node.Node::beforeOnValidInput()
     */
    protected function beforeOnValidInput()
    {
       if ($this->validInputCallback !== null) {
           $callback = $this->validInputCallback;
           $callback($this);
       }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Node.Node::beforeOnInputFailed()
     */
    protected function beforeOnInputFailed()
    {
       if ($this->failedInputCallback !== null) {
           $callback = $this->failedInputCallback;
           $callback($this);
       }
    }
}