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

use PAGI\Client\ClientIterface;
use PAGI\Node\Exception\NodeException;

/**
 * A node, used to get input from the user, validate it, play prompt messages,
 * etc.
 */
class Node
{
    /**
     * Any of the available DTMF digits in a classic telephone.
     *
     * @var string
     */
    const DTMF_ANY = '0123456789*#';

    /**
     * DTMF digit '*'
     *
     * @var string
     */
    const DTMF_STAR = '*';

    /**
     * DTMF digit '#'
     *
     * @var string
     */
    const DTMF_HASH = '#';

    /**
     * DTMF digits which are integers (numbers).
     *
     * @var string
     */
    const DTMF_NUMERIC = '1234567890';

    /**
     * DTMF digits non numeric.
     *
     * @var string
     */
    const DTMF_NONNUMERIC = '#*';

    /**
     * DTMF digit '1'
     *
     * @var string
     */
    const DTMF_1 = '1';

    /**
     * DTMF digit '2'
     *
     * @var string
     */
    const DTMF_2 = '2';

    /**
     * DTMF digit '3'
     *
     * @var string
     */
    const DTMF_3 = '3';

    /**
     * DTMF digit '4'
     *
     * @var string
     */
    const DTMF_4 = '4';

    /**
     * DTMF digit '5'
     *
     * @var string
     */
    const DTMF_5 = '5';

    /**
     * DTMF digit '6'
     *
     * @var string
     */
    const DTMF_6 = '6';

    /**
     * DTMF digit '7'
     *
     * @var string
     */
    const DTMF_7 = '7';

    /**
     * DTMF digit '8'
     *
     * @var string
     */
    const DTMF_8 = '8';

    /**
     * DTMF digit '9'
     *
     * @var string
     */
    const DTMF_9 = '9';

    /**
     * DTMF digit '0'
     *
     * @var string
     */
    const DTMF_0 = '0';

    /**
     * No DTMFs.
     *
     * @var string
     */
    const DTMF_NONE = null;

    /**
     * State when the node has not be run yet.
     *
     * @var integer
     */
    const STATE_NOT_RUN = 1;

    /**
     * State reached when the node can be cancelled (it has a cancel digit set)
     * and the user pressed it.
     *
     * @var integer
     */
    const STATE_CANCEL = 2;

    /**
     * State reached when the input is considered complete (it has at least
     * the minimum number of digits).
     *
     * @var integer
     */
    const STATE_COMPLETE = 3;

    /**
     * The user has not entered any input.
     *
     * @var integer
     */
    const STATE_TIMEOUT = 4;

    /**
     * The user exceeded the maximum number of attempts allowed to enter
     * a valid option.
     *
     * @var integer
     */
    const STATEmaxInputS_REACHED = 5;

    /**
     * Used when evaluating input, returned when the user presses the end of
     * input digit.
     *
     * @var integer
     */
    const INPUT_END = 1;

    /**
     * Used when evaluating input, returned when the user presses the cancel
     * digit.
     *
     * @var integer
     */
    const INPUT_CANCEL = 2;

    /**
     * Used when evaluating input, returned when the user presses a digit
     * that is not a cancel or end of input digit.
     *
     * @var integer
     */
    const INPUT_NORMAL = 3;

    /**
     * Used to specify infinite time for timeouts.
     *
     * @var integer
     */
    const TIME_INFINITE = -1;

    /**
     * Holds the agi client.
     *
     * @var ClientIterface
     */
    private $client = null;

    /**
     * Here's where the user input is appended one digit at the time.
     *
     * @var string
     */
    private $input = self::DTMF_NONE;

    /**
     * Node state.
     *
     * @var integer
     */
    private $state = self::STATE_NOT_RUN;

    /**
     * Holds the configured end of input digit.
     *
     * @var string
     */
    private $endOfInputDigit = 'X';

    /**
     * Holds the configured cancel digit.
     *
     * @var string
     */
    private $cancelDigit = 'X';

    /**
     * The minimum configured expected input length.
     *
     * @var integer
     */
    private $minInput = 0;

    /**
     * The maximum configured expected input length.
     *
     * @var integer
     */
    private $maxInput = 0;

    /**
     * In milliseconds, maximum time to wait for user input between digits.
     * Only taken into account when expecting input outside prompt and preprompt
     * messages.
     *
     * @var integer
     */
    private $timeBetweenDigits = self::TIME_INFINITE;

    /**
     * In milliseconds, maximum time to wait for a complete user input (per
     * attempt).
     *
     * @var integer
     */
    private $totalTimeForInput = self::TIME_INFINITE;

    /**
     * Holds the prompt messages (actions) to be used before expecting the user
     * input (like sounds, numbers, datetimes, etc).
     *
     * @var array
     */
    private $promptMessages = array();

    /**
     * Similar to prompt messages, but dynamically populated and cleared with
     * pre prompt messages, like error messages from validations.
     *
     * @var array
     */
    private $prePromptMessages = array();

    /**
     * True if the pre prompt messages can be interrupted with a dtmf digit.
     *
     * @var Boolean
     */
    private $prePromptMessagesInterruptable = true;

    /**
     * When the user can interrupt the pre prompt messages, this will indicate
     * if the digit pressed count as input (thus, discarding the prompt
     * messages).
     *
     * @var Boolean
     */
    private $acceptPrePromptInputAsInput = true;

    /**
     * Node name.
     *
     * @var string
     */
    private $name = 'X';

    /**
     * Holds all input validators.
     *
     * @var array
     */
    private $inputValidations = array();

    /**
     * Total attempts for the user to enter a valid input. Will loop input
     * routine this many times when the input is not validated.
     *
     * @var integer
     */
    private $totalAttemptsForInput = 1;

    /**
     * Optional message to play when the user did not enter any digits on
     * input.
     *
     * @var string
     */
    private $onNoInputMessage = null;

    /**
     * Optinal message to play when the user exceeded the maximum allowed
     * attempts to enter a valid input.
     *
     * @var message
     */
    private $onMaxValidInputAttempts = null;

    /**
     * True if prompt messages can be interrupted.
     *
     * @var Boolean
     */
    private $promptsCanBeInterrupted = true;

    /**
     * When pre prompt or prompt messages can be interrupted, these are the
     * valid interrupt digits.
     *
     * @var string
     */
    private $validInterruptDigits = self::DTMF_ANY;

    /**
     * Carries state. This is where optional custom data can be saved in the
     * callbacks and 3rd party software. Keys are strings.
     *
     * @var array
     */
    private $registry = array();

    /**
     * Callback to execute on valid input from the user.
     *
     * @var \Closure
     */
    private $executeOnValidInput = null;

    /**
     * Callback to execute when the node failed to correctly
     * Enter description here ...
     *
     * @var \Closure
     */
    private $executeOnInputFailed = null;

    /**
     * When true, the user may retry the input by pressing the cancel button
     * if and only if he/she has already input one or more digits.
     *
     * @var Boolean
     */
    private $cancelWithInputRetriesInput = false;

    /**
     * Used to save the total amount of opportunities used to enter valid input.
     *
     * @var integer
     */
    private $inputAttemptsUsed = 0;

    /**
     * Execute before running this node.
     *
     * @var \Closure
     */
    private $executeBeforeRun = null;

    /**
     * Execute after running this node.
     *
     * @var \Closure
     */
    private $executeAfterRun = null;

    /**
     * Execute after a validation has failed.
     *
     * @var \Closure
     */
    private $executeAfterFailedValidation = null;

    /**
     * Play "no input" message in last attempt too.
     *
     * @var Boolean
     */
    private $playOnNoInputInLastAttempt = false;

    /**
     * Make pre prompt messages not interruptable
     *
     * @return Node
     */
    public function prePromptMessagesNotInterruptable()
    {
        $this->prePromptMessagesInterruptable = false;
        $this->validInterruptDigits = self::DTMF_NONE;

        return $this;
    }

    /**
     * Digits entered during the pre prompt messages are not considered
     * as node input.
     *
     * @return Node
     */
    public function dontAcceptPrePromptInputAsInput()
    {
        $this->acceptPrePromptInputAsInput = false;

        return $this;
    }

    /**
     * Make prompt messages not interruptable.
     *
     * @return Node
     */
    public function unInterruptablePrompts()
    {
        $this->promptsCanBeInterrupted = false;
        $this->validInterruptDigits = self::DTMF_NONE;

        return $this;
    }

    /**
     * Specify an optional message to play when the user did not enter any
     * input at all. By default, will NOT be played if this happens in the last
     * allowed attempt.
     *
     * @param string $filename Sound file to play
     *
     * @return Node
     */
    public function playOnNoInput($filename)
    {
        $this->onNoInputMessage = $filename;

        return $this;
    }

    /**
     * Forces to play "no input" message on last attempt too.
     *
     * @return Node
     */
    public function playNoInputMessageOnLastAttempt()
    {
        $this->playOnNoInputInLastAttempt = true;

        return $this;
    }

    /**
     * Optional message to play when the user exhausted all the available
     * attempts to enter a valid input.
     *
     * @param string $filename Sound file to play
     *
     * @return Node
     */
    public function playOnMaxValidInputAttempts($filename)
    {
        $this->onMaxValidInputAttempts = $filename;

        return $this;
    }

    /**
     * Specify a maximum attempt number for the user to enter a valid input.
     * Defaults to 1.
     *
     * @param integer $number
     *
     * @return Node
     */
    public function maxAttemptsForInput($number)
    {
        $this->totalAttemptsForInput = $number;

        return $this;
    }

    /**
     * Given a callback and an optional sound to play on error, this will
     * return a validator information structure to be used with
     * validateInputWith().
     *
     * @param \Closure $validation   Callback to use as validator
     * @param string   $soundOnError Sound file to play on error
     *
     * @return array
     */
    public static function createValidatorInfo(\Closure $validation, $soundOnError = null)
    {
        return array(
            'callback' => $validation,
            'soundOnError' => $soundOnError
        );
    }

    /**
     * Given an array of validator information structures, this will load
     * all validators into this node.
     *
     * @param array $validatorsInformation
     *
     * @return Node
     */
    public function loadValidatorsFrom(array $validatorsInformation = array())
    {
        foreach ($validatorsInformation as $name => $validatorInfo) {
            $this->validateInputWith(
                $name, $validatorInfo['callback'], $validatorInfo['soundOnError']
            );
        }

        return $this;
    }

    /**
     * Add an input validation to this node.
     *
     * @param string   $name         A distrinctive name for this validator
     * @param \Closure $validation   Callback to use for validation
     * @param string   $soundOnError Optional sound to play on error
     *
     * @return Node
     */
    public function validateInputWith($name, \Closure $validation, $soundOnError = null)
    {
        $this->inputValidations[$name] = self::createValidatorInfo(
            $validation, $soundOnError
        );

        return $this;
    }

    /**
     * Calls all validators in order. Will stop when any of them returns false.
     *
     * @return Boolean
     */
    public function validate()
    {
        foreach ($this->inputValidations as $name => $data) {
            $validator = $data['callback'];
            $result = $validator($this);

            // validation failed
            if ($result === false) {
                $onError = $data['soundOnError'];

                if (is_array($onError)) {
                    foreach ($onError as $message) {
                        $this->addPrePromptMessage($message);
                    }
                } else {
                    $this->addPrePromptMessage($onError);
                }

                return false;
            }
        }

        return true;
    }

    /**
     * Removes prompt messages.
     *
     * @return Node
     */
    public function clearPromptMessages()
    {
        $this->promptMessages = array();

        return $this;
    }

    /**
     * Internally used to execute prompt messages in the agi client.
     */
    protected function addClientMethodCall()
    {
        $args = func_get_args();
        $name = array_shift($args);
        $this->promptMessages[] = array($name => $args);
    }

    /**
     * Internally used to execute pre prompt messages in the agi client.
     */
    protected function addPrePromptClientMethodCall()
    {
        $args = func_get_args();
        $name = array_shift($args);
        $this->prePromptMessages[] = array($name => $args);
    }

    /**
     * Adds a sound file to play as a pre prompt message.
     *
     * @param string $filename
     */
    public function addPrePromptMessage($filename)
    {
        $this->addPrePromptClientMethodCall(
            'streamFile', $filename, $this->validInterruptDigits
        );
    }

    /**
     * Loads a prompt message for saying the digits of the given number.
     *
     * @param integer $digits
     *
     * @return Node
     */
    public function sayDigits($digits)
    {
        $this->addClientMethodCall('sayDigits', $digits, $this->validInterruptDigits);

        return $this;
    }

    /**
     * Loads a prompt message for saying a number.
     *
     * @param integer $number
     *
     * @return Node
     */
    public function sayNumber($number)
    {
        $this->addClientMethodCall('sayNumber', $number, $this->validInterruptDigits);

        return $this;
    }

    /**
     * Loads a prompt message for saying a date/time expressed by a unix
     * timestamp and a format.
     *
     * @param integer $timestamp
     * @param string  $format
     *
     * @return Node
     */
    public function sayDateTime($timestamp, $format)
    {
        $this->addClientMethodCall('sayDateTime', $timestamp, $format, $this->validInterruptDigits);

        return $this;
    }

    /**
     * Loads a prompt message for playing an audio file.
     *
     * @param string $filename
     *
     * @return Node
     */
    public function saySound($filename)
    {
        $this->addClientMethodCall('streamFile', $filename, $this->validInterruptDigits);

        return $this;
    }

    /**
     * Configure the node to expect at least this many digits. The input is
     * considered complete when this many digits has been entered. Cancel and
     * end of input digits (if configured) are not taken into account.
     *
     * @param integer $length
     *
     * @return Node
     */
    public function expectAtLeast($length)
    {
        $this->minInput = $length;

        return $this;
    }

    /**
     * Configure the node to expect at most this many digits. The reading loop
     * will try to read this many digits.
     *
     * @param integer $length
     *
     * @return Node
     */
    public function expectAtMost($length)
    {
        $this->maxInput = $length;

        return $this;
    }

    /**
     * Configure this node to expect at least and at most this many digits.
     *
     * @param integer $length
     *
     * @return Node
     */
    public function expectExactly($length)
    {
        return $this->expectAtLeast($length)->expectAtMost($length);
    }

    /**
     * Configures a specific digit as the cancel digit.
     *
     * @param char $digit
     *
     * @return Node
     */
    public function cancelWith($digit)
    {
        $this->cancelDigit = $digit;

        return $this;
    }

    /**
     * Configures a specific digit as the end of input digit.
     *
     * @param char $digit
     *
     * @return Node
     */
    public function endInputWith($digit)
    {
        $this->endOfInputDigit = $digit;

        return $this;
    }

    /**
     * Configures the maximum time available between digits before a timeout.
     *
     * @param integer $milliseconds
     *
     * @return Node
     */
    public function maxTimeBetweenDigits($milliseconds)
    {
        $this->timeBetweenDigits = $milliseconds;

        return $this;
    }

    /**
     * Configures the maximum time available for the user to enter valid input
     * per attempt.
     *
     * @param integer $milliseconds
     *
     * @return Node
     */
    public function maxTotalTimeForInput($milliseconds)
    {
        $this->totalTimeForInput = $milliseconds;

        return $this;
    }

    /**
     * True if this node has at least this many digits entered.
     *
     * @param integer $length
     *
     * @return Boolean
     */
    public function inputLengthIsAtLeast($length)
    {
        return strlen($this->input) >= $length;
    }

    /**
     * True if this node has at least 1 digit as input, excluding cancel and
     * end of input digits.
     *
     * @return Boolean
     */
    public function hasInput()
    {
        return $this->inputLengthIsAtLeast(1);
    }

    /**
     * Returns input.
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Returns the agi client in use.
     *
     * @return ClientIterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Gives a name for this node.
     *
     * @param string $name
     *
     * @return Node
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets the agi client to use by this node.
     *
     * @param ClientIterface $client
     *
     * @return Node
     */
    public function setAgClientIterface(ClientIterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Appends an input to the node input.
     *
     * @param char $digit
     */
    protected function appendInput($digit)
    {
        $this->input .= $digit;
    }

    /**
     * True if the digit matches the cancel digit.
     *
     * @param char $digit
     *
     * @return Boolean
     */
    protected function inputIsCancel($digit)
    {
        return $digit == $this->cancelDigit;
    }

    /**
     * True if the digit matches the end of input digit.
     *
     * @param char $digit
     *
     * @return Boolean
     */
    protected function inputIsEnd($digit)
    {
        return $digit == $this->endOfInputDigit;
    }

    /**
     * Returns the kind of digit entered by the user, CANCEL, END, NORMAL.
     *
     * @param char $digit
     *
     * @return integer
     */
    protected function evaluateInput($digit)
    {
        if ($this->inputIsCancel($digit)) {
            return self::INPUT_CANCEL;
        }

        if ($this->inputIsEnd($digit)) {
            return self::INPUT_END;
        }

        return self::INPUT_NORMAL;
    }

    /**
     * Process a single digit input by the user. Changes the node state
     * according to the digit entered (CANCEL, COMPLETE).
     *
     * @param char $digit
     */
    protected function acceptInput($digit)
    {
        switch ($this->evaluateInput($digit)) {
            case self::INPUT_CANCEL:
                $this->state = self::STATE_CANCEL;
                break;

            case self::INPUT_END:
                $this->state = self::STATE_COMPLETE;
                break;

            default:
                $this->appendInput($digit);
                if ($this->minInput > 0 && $this->inputLengthIsAtLeast($this->minInput)) {
                    $this->state = self::STATE_COMPLETE;
                }
        }
    }

    /**
     * True if the user reached the maximum allowed attempts for valid input.
     *
     * @return Boolean
     */
    public function maxInputsReached()
    {
        return $this->state == self::STATEmaxInputS_REACHED;
    }

    /**
     * True if this node is in CANCEL state.
     *
     * @return Boolean
     */
    public function wasCancelled()
    {
        return $this->state == self::STATE_CANCEL;
    }

    /**
     * True if this node is in TIMEOUT state.
     *
     * @return Boolean
     */
    public function isTimeout()
    {
        return $this->state == self::STATE_TIMEOUT;
    }

    /**
     * True if this node is in COMPLETE state.
     *
     * @return Boolean
     */
    public function isComplete()
    {
        return $this->state == self::STATE_COMPLETE;
    }

    /**
     * Call a specific method on a client.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return \PAGI\Client\Result\ResultInterface
     */
    protected function callClientMethod($name, array $arguments = array())
    {
        return call_user_func_array(array($this->client, $name), $arguments);
    }

    /**
     * Calls methods in the agi client.
     *
     * @param array $methods Methods to call, an array of arrays. The
     *                           second array has the method name as key
     *                           and an array of arguments as value.
     * @param \Closure $stopWhen If any, this callback is evaluated before
     *                           returning. Will return when false.
     *
     * @return \PAGI\Client\Result\ResultInterface
     */
    protected function callClientMethods(array $methods = array(), $stopWhen = null)
    {
        $result = null;

        foreach ($methods as $callInfo) {
            foreach ($callInfo as $name => $arguments) {
                $result = $this->callClientMethod($name, $arguments);

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
     * Plays pre prompt messages, like error messages from validations.
     *
     * @return \PAGI\Client\Result\ResultInterface
     */
    protected function playPromptMessages()
    {
        $interruptable = $this->promptsCanBeInterrupted;

        $result = $this->callClientMethods(
            $this->promptMessages,

            function($result) use ($interruptable) {
                return $interruptable && !$result->isTimeout();
            }
        );

        return $result;
    }

    /**
     * Internally used to clear pre prompt messages after being played.
     */
    protected function clearPrePromptMessages()
    {
        $this->prePromptMessages = array();
    }

    /**
     * Internally used to play all pre prompt queued messages. Clears the
     * queue after it.
     *
     * @return \PAGI\Client\Result\ResultInterface
     */
    protected function playPrePromptMessages()
    {
        $interruptable = $this->prePromptMessagesInterruptable;

        $result = $this->callClientMethods(
            $this->prePromptMessages,

            function($result) use ($interruptable) {
                return $interruptable && !$result->isTimeout();
            }
        );

        $this->clearPrePromptMessages();

        return $result;
    }

    /**
     * Saves a custom key/value to the registry.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return Node
     */
    public function saveCustomData($key, $value)
    {
        $this->registry[$key] = $value;

        return $this;
    }

    /**
     * Returns the value for the given key in the registry.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getCustomData($key)
    {
        return $this->registry[$key];
    }

    /**
     * True if the given key exists in the registry.
     *
     * @param string $key
     *
     * @return Boolean
     */
    public function hasCustomData($key)
    {
        return isset($this->registry[$key]);
    }

    /**
     * Remove a key/value from the registry.
     *
     * @param string $key
     *
     * @return Node
     */
    public function delCustomData($key)
    {
        unset($this->registry[$key]);

        return $this;
    }

    /**
     * Allow the user to retry input by pressing the cancel digit after entered
     * one or more digits. For example, when entering a 12 number pin, the user
     * might press the cancel digit at the 5th digit to re-enter it. This
     * counts as a failed input, but will not cancel the node. The node will be
     * cancelled only if the user presses the cancel digit with NO input at all.
     *
     * @return Node
     */
    public function cancelWithInputRetriesInput()
    {
        $this->cancelWithInputRetriesInput = true;

        return $this;
    }

    /**
     * Specify a callback function to invoke when the user entered a valid
     * input.
     *
     * @param \Closure $callback
     *
     * @return Node
     */
    public function executeOnValidInput(\Closure $callback)
    {
        $this->executeOnValidInput = $callback;

        return $this;
    }

    /**
     * Executes a callback when the node fails to properly get input from the
     * user (either because of cancel, max attempts reached, timeout).
     *
     * @param \Closure $callback
     *
     * @return Node
     */
    public function executeOnInputFailed(\Closure $callback)
    {
        $this->executeOnInputFailed = $callback;

        return $this;
    }

    /**
     * Returns the total number of input attempts used by the user.
     *
     * @return integer
     */
    public function getTotalInputAttemptsUsed()
    {
        return $this->inputAttemptsUsed;
    }

    /**
     * Internally used to clear the input per input attempt. Also resets state
     * to TIMEOUT.
     *
     * @return Node
     */
    protected function resetInput()
    {
        if ($this->minInput === 0) {
            $this->state = self::STATE_COMPLETE;
        } else {
            $this->state = self::STATE_TIMEOUT;
        }

        $this->input = self::DTMF_NONE;

        return $this;
    }

    /**
     * Internally used to accept input from the user. Plays pre prompt messages,
     * prompt, and waits for a complete input or cancel.
     */
    protected function doInput()
    {
        $this->resetInput();
        $this->inputAttemptsUsed++;

        $result = $this->playPrePromptMessages();

        if (!$this->acceptPrePromptInputAsInput) {
            $result = $this->playPromptMessages();
            if ($result !== null && !$result->isTimeout()) {
                $this->acceptInput($result->getDigits());
            }
        } elseif ($result !== null && !$result->isTimeout()) {
            $this->acceptInput($result->getDigits());
        } else {
            $result = $this->playPromptMessages();
            if ($result !== null) {
                $this->acceptInput($result->getDigits());
            }
        }

        if (
            $this->inputLengthIsAtLeast($this->maxInput) // max = 1
            || $this->wasCancelled()
            || ($this->isComplete() && !$this->hasInput()) // user pressed eoi
        ) {
            return;
        }

        $len = strlen($this->input);
        $start = time();

        for ($i = $len; $i < $this->maxInput; $i++) {
            if ($this->totalTimeForInput != -1) {
                $totalElapsedTime = (time() - $start) * 1000;

                // expired total available time for input
                if ($totalElapsedTime >= $this->totalTimeForInput) {
                    break;
                }
            }

            // reading digit #..
            $result = $this->callClientMethods(array(
                array('waitDigit' => array($this->timeBetweenDigits))
            ));

            // expired available time per digit
            if ($result->isTimeout()) {
                break;
            }

            $input = $result->getDigits();
            $this->acceptInput($input);

            if ($this->inputIsEnd($input) || $this->wasCancelled()) {
                break;
            }
        }
    }

    /**
     * Convenient hook to execute before calling the onValidInput callback.
     */
    protected function beforeOnValidInput()
    {
    }

    /**
     * Convenient hook to execute before calling the onInputFailed callback.
     */
    protected function beforeOnInputFailed()
    {
    }

    /**
     * Executes before running the node.
     *
     * @param \closure $callback
     *
     * @return Node
     */
    public function executeBeforeRun(\Closure $callback)
    {
        $this->executeBeforeRun = $callback;

        return $this;
    }

    /**
     * Executes after running the node.
     *
     * @param \Closure $callback
     *
     * @return Node
     */
    public function executeAfterRun(\Closure $callback)
    {
        $this->executeAfterRun = $callback;

        return $this;
    }

    /**
     * Executes after the 1st failed validation.
     *
     * @param \Closure $callback
     *
     * @return Node
     */
    public function executeAfterFailedValidation(\Closure $callback)
    {
        $this->executeAfterFailedValidation = $callback;

        return $this;
    }

    /**
     * Executes this node.
     *
     * @return Node
     */
    public function run()
    {
        $this->inputAttemptsUsed = 0;

        if ($this->executeBeforeRun !== null) {
            $callback = $this->executeBeforeRun;
            $callback($this);
        }

        for ($attempts = 0; $attempts < $this->totalAttemptsForInput; $attempts++) {
            $this->doInput();

            if ($this->wasCancelled()) {
                // cancelled input, retrying
                if ($this->cancelWithInputRetriesInput && $this->hasInput()) {
                    continue;
                }

                // cancelled node, quitting
                break;
            }

            // dont play on last attempt by default
            if (
                $this->onNoInputMessage !== null
                && !$this->hasInput()
                && ($this->playOnNoInputInLastAttempt || $attempts != ($this->totalAttemptsForInput - 1))
            ) {
                $this->addPrePromptMessage($this->onNoInputMessage);
                continue;
            }

            if ($this->hasInput()) {
                if ($this->validate()) {
                    // input validated
                    if ($this->executeOnValidInput !== null) {
                        $callback = $this->executeOnValidInput;
                        $this->beforeOnValidInput();
                        $callback($this);
                    }

                    break;
                } elseif ($this->executeAfterFailedValidation !== null) {
                    $callback = $this->executeAfterFailedValidation;
                    $callback($this);
                }
            }
        }

        $result = $this->playPrePromptMessages();

        if ($this->minInput > 0 && $attempts == $this->totalAttemptsForInput) {
            // max attempts reached
            $this->state = self::STATEmaxInputS_REACHED;

            if ($this->onMaxValidInputAttempts !== null) {
                $this->callClientMethods(array(
                    array('streamFile' => array($this->onMaxValidInputAttempts, self::DTMF_ANY))
                ));
            }
        }

        if (!$this->isComplete() && $this->executeOnInputFailed !== null) {
            $callback = $this->executeOnInputFailed;
            $this->beforeOnInputFailed();
            $callback($this);
        }

        if ($this->executeAfterRun !== null) {
            $callback = $this->executeAfterRun;
            $callback($this);
        }

        return $this;
    }

    /**
     * Returns the node name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Maps the current node state to a human readable string.
     *
     * @return string
     */
    protected function stateToString($state)
    {
        switch ($state) {
            case self::STATE_CANCEL:
                return 'cancel';

            case self::STATE_COMPLETE:
                return 'complete';

            // a string like 'foo' matches here?
            case self::STATE_NOT_RUN:
                return 'not run';

            case self::STATE_TIMEOUT:
                return 'timeout';

            case self::STATEmaxInputS_REACHED:
                return 'max valid input attempts reached';

            default:
                throw new NodeException('Bad state for node');
        }
    }

    /**
     * A classic!
     *
     * @return string
     */
    public function __toString()
    {
        return sprint('[ Node: input: (%s) state: (%s) ]', $this->name, $this->input, $this->stateToString($this->state));
    }
}
