<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Node;

use PAGI\Exception\MockedException;

/**
 * A Mocked node. Useful for testing ivr applications.
 */
class MockedNode extends Node
{
    /**
     * The complete input digit chain for this node.
     *
     * @var string
     */
    private $mockedInput = array();

    /**
     * The expected number of times that prompt messages need to be played
     * (keys are agi client method names).
     *
     * @var array
     */
    private $expectedSay = array();

    /**
     * The counter of prompt messages actually played
     * (keys are agi client method names).
     *
     * @var array
     */
    private $doneSay = array();

    /**
     * Default expected state.
     *
     * @var integer
     */
    private $expectedState = Node::STATE_NOT_RUN;

    /**
     * Optional callback to be used before executing the onInputValid callback.
     *
     * @var \Closure
     */
    private $validInputCallback = null;

    /**
     * Optional callback to be used before executing the onInputFailed callback.
     *
     * @var \Closure
     */
    private $failedInputCallback = null;

    /**
     * Configures this node to expect a given filename to be played n number
     * of times.
     *
     * @param string  $filename
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
     * @param string $what      The agi method name called
     * @param array  $arguments The arguments used, without the interrupt
     *                          digits
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
     * @param string  $what       The agi method name to expect
     * @param integer $totalTimes Total times to expect this call
     * @param array   $arguments  The arguments to assert
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
     * {@inheritdoc}
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
                    sprintf('%s (%s) expected to be called %d times, was called %d times',
                        $what,
                        implode(',', $arguments),
                        $times,
                        $doneTimes
                    )
                );
            }
        }

        if ($this->expectedState != Node::STATE_NOT_RUN) {
            if ($this->expectedState != $this->state) {
                throw new MockedException(
                    sprintf('Expected state: %s vs. Current: %s',
                        parent::stateToString($this->expectedState),
                        parent::stateToString($this->state)
                    )
                );
            }
        }

        return $result;
    }

    /**
     * Used to mimic the user input per prompt message.
     *
     * @param string $what
     * @param array  $arguments
     */
    protected function sayInterruptable($what, array $arguments)
    {
        $client = $this->getClient();

        $argsCount = count($arguments);
        $interruptDigits = $arguments[$argsCount - 1];

        $this->recordDoneSay($what, array_slice($arguments, 0, $argsCount - 1));

        if (empty($this->mockedInput)) {
            $client->onStreamFile(false);
        } else {
            if ($interruptDigits != Node::DTMF_NONE) {
                $digit = array_shift($this->mockedInput);
                if (strpos($interruptDigits, $digit) !== false) {
                    $client->onStreamFile(true, $digit);
                } else {
                    $client->onStreamFile(false);
                }
            } else {
                $client->onStreamFile(false);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function callClientMethods($methods, $stopWhen = null)
    {
        $client = $this->getClient();

        $result = null;

        foreach ($methods as $callInfo) {
            foreach ($callInfo as $name => $arguments) {
                switch ($name) {
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
     * @return MockedNode
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
     * @return MockedNode
     */
    public function doBeforeFailedInput(\Closure $callback)
    {
        $this->failedInputCallback = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeOnValidInput()
    {
       if ($this->validInputCallback !== null) {
           $callback = $this->validInputCallback;
           $callback($this);
       }
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeOnInputFailed()
    {
       if ($this->failedInputCallback !== null) {
           $callback = $this->failedInputCallback;
           $callback($this);
       }
    }
}
