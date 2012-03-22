<?php
namespace PAGI\Node;

use PAGI\Client\IClient;
use PAGI\Node\Exception\NodeException;

class Node
{
    /**
     * Any of the available DTMF digits in a classic telephone.
     * @var string
     */
    const DTMF_ANY = '0123456789*#';
    const DTMF_STAR = '*';
    const DTMF_HASH = '#';
    /**
     * DTMF digits which are integers (numbers)
     * @var string
     */
    const DTMF_NUMERIC = '1234567890';
    /**
     * DTMF digits non numeric
     * @var string
     */
    const DTMF_NONNUMERIC = '#*';
    /**
     * DTMF digit '1'
     * @var string
     */
    const DTMF_1 = '1';
    const DTMF_2 = '2';
    const DTMF_3 = '3';
    const DTMF_4 = '4';
    const DTMF_5 = '5';
    const DTMF_6 = '6';
    const DTMF_7 = '7';
    const DTMF_8 = '8';
    const DTMF_9 = '9';
    const DTMF_0 = '0';

    /**
     * State when the node has not be run yet.
     * @var integer
     */
    const STATE_NOT_RUN = 0;
    /**
     * State reached when the node can be cancelled (it has a cancel digit set)
     * and the user pressed it.
     * @var integer
     */
    const STATE_CANCEL = 1;
    /**
     * State reached when the input is considered complete (it has at least
     * the minimum number of digits)
     * @var integer
     */
    const STATE_COMPLETE = 2;
    /**
     * The user has not entered any input.
     * @var integer
     */
    const STATE_TIMEOUT = 3;
    /**
     * The user exceeded the maximum number of attempts allowed to enter
     * a valid option.
     * @var integer
     */
    const STATE_MAX_INPUTS_REACHED = 4;

    const INPUT_END = 0;
    const INPUT_CANCEL = 1;
    const INPUT_NORMAL = 2;

    private $_client = null;
    private $_input = '';
    private $_state = self::STATE_NOT_RUN;
    private $_endOfInputDigit = 'X';
    private $_cancelDigit = 'X';
    private $_minInput = 0;
    private $_maxInput = 0;
    private $_timeBetweenDigits = '-1';
    private $_totalTimeForInput = '-1';
    private $_promptMessages = array();
    private $_prePromptMessages = array();
    private $_prePromptMessagesInterruptable = true;
    private $_acceptPrePromptInputAsInput = true;
    /**
     * Node name.
     * @var string
     */
    private $_name = 'X';
    private $_inputValidations = array();
    private $_totalAttemptsForInput = 1;
    private $_errorMessages = array();
    private $_onNoInputMessage = null;
    private $_onMaxValidInputAttempts = null;
    private $_promptsCanBeInterrupted = true;
    private $_validInterruptDigits = self::DTMF_ANY;
    private $_registry = array();
    private $_executeOnValidInput = null;
    private $_executeOnInputFailed = null;
    private $_cancelWithInputRetriesInput = false;

    /**
     * Make pre prompt messages not interruptable
     *
     * @return Node
     */
    public function prePromptMessagesNotInterruptable()
    {
        $this->_prePromptMessagesInterruptable = false;
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
        $this->_acceptPrePromptInputAsInput = false;
        return $this;
    }

    /**
     * Make prompt messages not interruptable.
     *
     * @return Node
     */
    public function unInterruptablePrompts()
    {
        $this->_promptsCanBeInterrupted = false;
        $this->_validInterruptDigits = '';
        return $this;
    }

    /**
     * Specify an optional message to play when the user did not enter any
     * input at all. Will NOT be played if this happens in the last allowed
     * attempt.
     *
     * @param string $filename Sound file to play.
     *
     * @return Node
     */
    public function playOnNoInput($filename)
    {
        $this->_onNoInputMessage = $filename;
        return $this;
    }

    /**
     * Optional message to play when the user exhausted all the available
     * attempts to enter a valid input.
     *
     * @param string $filename Sound file to play.
     *
     * @return Node
     */
    public function playOnMaxValidInputAttempts($filename)
    {
        $this->_onMaxValidInputAttempts = $filename;
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
        $this->_totalAttemptsForInput = $number;
        return $this;
    }

    /**
     * Given a callback and an optional sound to play on error, this will
     * return a validator information structure to be used with
     * validateInputWith().
     *
     * @param \Closure $validation Callback to use as validator
     * @param string|null $soundOnError Sound file to play on error
     *
     * @return validatorInfo
     */
    public static function createValidatorInfo(
        \Closure $validation, $soundOnError = null
    ) {
        return array(
            'callback' => $validation,
            'soundOnError' => $soundOnError
        );
    }

    /**
     * Given an array of validator information structures, this will load
     * all validators into this node.
     *
     * @param validatorInfo[] $validatorsInformation
     *
     * @return Node
     */
    public function loadValidatorsFrom(array $validatorsInformation)
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
     * @param string $name A distrinctive name for this validator
     * @param \Closure $validation Callback to use for validation
     * @param string|null $soundOnError Optional sound to play on error
     *
     * @return Node
     */
    public function validateInputWith($name, \Closure $validation, $soundOnError = null)
    {
        $this->_inputValidations[$name] = self::createValidatorInfo(
            $validation, $soundOnError
        );
        return $this;
    }

    /**
     * Calls all validators in order. Will stop when any of them returns false.
     *
     * @return boolean
     */
    public function validate()
    {
        foreach ($this->_inputValidations as $name => $data) {
            $validator = $data['callback'];
            $result = $validator($this);
            if ($result === false) {
                $this->logDebug("Validation FAILED: $name");
                $onError = $data['soundOnError'];
                if (is_array($onError)) {
                    foreach ($onError as $msg) {
                        $this->addPrePromptMessage($msg);
                    }
                } else {
                    $this->addPrePromptMessage($onError);
                }
                return false;
            }
            $this->logDebug("Validation OK: $name");
        }
        return true;
    }

    /**
     * Internally used to execute prompt messages in the agi client.
     *
     * @return void
     */
    protected function addClientMethodCall()
    {
        $args = func_get_args();
        $name = array_shift($args);
        $this->_promptMessages[] = array($name => $args);
    }

    /**
     * Internally used to execute pre prompt messages in the agi client.
     *
     * @return void
     */
    protected function addPrePromptClientMethodCall()
    {
        $args = func_get_args();
        $name = array_shift($args);
        $this->_prePromptMessages[] = array($name => $args);
    }

    /**
     * Adds a sound file to play as a pre prompt message.
     *
     * @param string $filename
     *
     * @return void
     */
    protected function addPrePromptMessage($filename)
    {
        $this->addPrePromptClientMethodCall(
        	'streamFile', $filename, $this->_validInterruptDigits
        );
    }

    public function sayDigits($digits)
    {
        $this->addClientMethodCall('sayDigits', $digits, $this->_validInterruptDigits);
        return $this;
    }

    public function sayNumber($number)
    {
        $this->addClientMethodCall('sayNumber', $number, $this->_validInterruptDigits);
        return $this;
    }

    public function sayDateTime($timestamp, $format)
    {
        $this->addClientMethodCall('sayDateTime', $timestamp, $format, $this->_validInterruptDigits);
        return $this;
    }

    public function saySound($filename)
    {
        $this->addClientMethodCall('streamFile', $filename, $this->_validInterruptDigits);
        return $this;
    }

    public function expectAtLeast($length)
    {
        $this->_minInput = $length;
        return $this;
    }

    public function expectAtMost($length)
    {
        $this->_maxInput = $length;
        return $this;
    }

    public function expectExactly($length)
    {
        return $this->expectAtLeast($length)->expectAtMost($length);
    }

    public function cancelWith($digit)
    {
        $this->_cancelDigit = $digit;
        return $this;
    }

    public function endInputWith($digit)
    {
        $this->_endOfInputDigit = $digit;
        return $this;
    }

    public function maxTimeBetweenDigits($milliseconds)
    {
        $this->_timeBetweenDigits = $milliseconds;
        return $this;
    }

    public function maxTotalTimeForInput($milliseconds)
    {
        $this->_totalTimeForInput = $milliseconds;
        return $this;
    }

    public function inputLengthIsAtLeast($length)
    {
        return strlen($this->_input) >= $length;
    }

    /**
     * True if this node has at least 1 digit as input, excluding cancel and
     * end of input digits.
     *
     * @return boolean
     */
    public function hasInput()
    {
        return $this->inputLenIsAtLeast(1);
    }

    /**
     * Returns input.
     *
     * @return string
     */
    public function getInput()
    {
        return $this->_input;
    }

    /**
     * Returns the agi client in use.
     *
     * @return \PAGI\Client\IClient
     */
    public function getClient()
    {
        return $this->_client;
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
        $this->_name = $name;
        return $this;
    }

    /**
     * Sets the pagi client to use by this node.
     *
     * @param \PAGI\Client\IClient $client
     *
     * @return Node
     */
    public function setAgiClient(IClient $client)
    {
        $this->_client = $client;
        return $this;
    }

    public static function create($name, $agiClient)
    {
        $node = new Node();
        return $node->setName($name)->setAgiClient($agiClient);
    }

    protected function appendInput($digit)
    {
        $this->_input .= $digit;
    }

    protected function inputIsCancel($digit)
    {
        return $digit == $this->_cancelDigit;
    }

    protected function inputIsEnd($digit)
    {
        return $digit == $this->_endOfInputDigit;
    }

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

    protected function acceptInput($digit)
    {
        switch($this->evaluateInput($digit)) {
        case self::INPUT_CANCEL:
            $this->_state = self::STATE_CANCEL;
            break;
        case self::INPUT_END:
            $this->_state = self::STATE_COMPLETE;
            break;
        default:
            $this->appendInput($digit);
            if ($this->inputLengthIsAtLeast($this->_minInput)) {
                $this->_state = self::STATE_COMPLETE;
            }
        }
    }

    public function maxInputsReached()
    {
        return $this->_state == self::STATE_MAX_INPUTS_REACHED;
    }

    public function wasCancelled()
    {
        return $this->_state == self::STATE_CANCEL;
    }

    public function isTimeout()
    {
        return $this->_state == self::STATE_TIMEOUT;
    }

    public function isComplete()
    {
        return $this->_state == self::STATE_COMPLETE;
    }

    protected function callClientMethods($methods, $stopWhen = null)
    {
        $result = null;
        foreach ($methods as $callInfo) {
            foreach ($callInfo as $name => $arguments) {
                $this->logDebug("$name(" . implode(",", $arguments) . ")");
                $result = call_user_func_array(
                    array($this->_client, $name), $arguments
                );
                if ($stopWhen !== null) {
                    if ($stopWhen($result)) {
                        return $result;
                    }
                }
            }
        }
        return $result;
    }

    protected function playPromptMessages()
    {
        $interruptable = $this->_promptsCanBeInterrupted;
        $result = $this->callClientMethods(
            $this->_promptMessages,
            function($result) use ($interruptable) {
                return $interruptable && !$result->isTimeout();
            }
        );
        return $result;
    }

    protected function clearPrePromptMessages()
    {
        $this->_prePromptMessages = array();
    }

    /**
     * Internally used to play all pre prompt queued messages. Clears the
     * queue after it.
     *
     * @return \PAGI\Client\Result\IResult
     */
    protected function playPrePromptMessages()
    {
        $interruptable = $this->_prePromptMessagesInterruptable;
        $result = $this->callClientMethods(
            $this->_prePromptMessages,
            function($result) use ($interruptable) {
                return $interruptable && !$result->isTimeout();
            }
        );
        $this->clearPrePromptMessages();
        return $result;
    }

    /**
     * Internally used to clear the input per input attempt. Also resets state
     * to TIMEOUT.
     *
	 * @return Node
     */
    protected function resetInput()
    {
        $this->_state = self::STATE_TIMEOUT;
        $this->_input = '';
        return $this;
    }

    /**
     * Internally used to accept input from the user. Plays pre prompt messages,
     * prompt, and waits for a complete input or cancel.
     *
     * @return void
     */
    protected function doInput()
    {
        $this->resetInput();
        $result = $this->playPrePromptMessages();
        if (!$this->_acceptPrePromptInputAsInput) {
            $result = $this->playPromptMessages();
            if ($result !== null && $result->isTimeout()) {
                $this->acceptInput($result->getDigits());
            }
        } else if ($result !== null && !$result->isTimeout()) {
            $this->acceptInput($result->getDigits());
        } else {
            $result = $this->playPromptMessages();
            $this->acceptInput($result->getDigits());
        }
        if ($this->isComplete() || $this->wasCancelled()) {
            return;
        }
        $len = strlen($this->_input);
        $start = time();
        for ($i = $len; $i < $this->_maxInput; $i++) {
            if ($this->_totalTimeForInput != -1) {
                $totalElapsedTime = (time() - $start) * 1000;
                if ($totalElapsedTime >= $this->_totalTimeForInput) {
                    $this->logDebug("Expired total available time for input");
                    break;
                }
            }
            $this->logDebug($this->_name . ": Reading Digit #: " . ($i + 1));
            $result = $this->_client->waitDigit($this->_timeBetweenDigits);
            if ($result->isTimeout()) {
                $this->logDebug("Expired available time per digit");
                break;
            }
            $input = $result->getDigits();
            $this->acceptInput($input);
            if ($this->inputIsEnd($input)) {
                break;
            }
        }
    }

    /**
     * Saves a custom key/value to the registry.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return Node
     */
    public function saveCustomData($key, $value)
    {
        $this->_registry[$key] = $value;
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
        return $this->_registry[$key];
    }

    /**
     * True if the given key exists in the registry.
     *
     * @param string $key
     *
     * @return boolean
     */
    public function hasCustomData($key)
    {
        return $this->_registry[$key];
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
        unset($this->_registry[$key]);
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
        $this->_cancelWithInputRetriesInput = true;
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
        $this->_executeOnValidInput = $callback;
        return $this;
    }

    public function executeOnInputFailed(\Closure $callback)
    {
        $this->_executeOnInputFailed = $callback;
        return $this;
    }

    /**
     * Executes this node.
     *
     * @return Node
     */
    public function run()
    {
        if (!($this->_client instanceof \PAGI\Client\IClient)) {
            throw new NodeException("Need a PAGI client to work with");
        }
        for ($attempts = 0; $attempts < $this->_totalAttemptsForInput; $attempts++) {
            $this->doInput();
            if ($this->wasCancelled()) {
                if ($this->_cancelWithInputRetriesInput && $this->inputLengthIsAtLeast(1)) {
                    $this->logDebug("Cancelled input, retrying");
                    continue;
                }
                $this->logDebug("Cancelled node, quitting");
                break;
            }
            if (
                $this->_onNoInputMessage !== null
                && !$this->inputLengthIsAtLeast(1)
                && $attempts != $this->_totalAttemptsForInput
            ) {
                $this->addPrePromptMessage($this->_onNoInputMessage);
                continue;
            }
            if ($this->inputLengthIsAtLeast(1) && $this->validate()) {
                $this->logDebug("Input validated");
                if ($this->_executeOnValidInput !== null) {
                    $callback = $this->_executeOnValidInput;
                    $callback($this);
                }
                break;
            }
        }
        if ($attempts == $this->_totalAttemptsForInput) {
            $this->logDebug("Max attempts reached");
            $this->_state = self::STATE_MAX_INPUTS_REACHED;
            if ($this->_onMaxValidInputAttempts !== null) {
                $this->callClientMethods(array(
                    array('streamFile' => array($this->_onMaxValidInputAttempts, self::DTMF_ANY))
                ));
            }
        }
        if (!$this->isComplete() && $this->_executeOnInputFailed !== null) {
            $callback = $this->_executeOnInputFailed;
            $callback($this);
        }
        $this->logDebug($this);
        return $this;
    }

    /**
     * Used internally to log debug messages
     *
     * @param string $msg
     *
     * @return void
     */
    protected function logDebug($msg)
    {
        $logger = $this->_client->getAsteriskLogger();
        $ani = $this->_client->getChannelVariables()->getCallerIdName();
        $dnis = $this->_client->getChannelVariables()->getDNIS();
        $logger->debug($this->_name . ": $ani -> $dnis: $msg");
    }

    /**
     * Maps the current node state to a human readable string.
     *
     * @return string
     */
    protected function stateToString()
    {
        switch ($this->_state) {
        case self::STATE_CANCEL:
            return "cancel";
        case self::STATE_COMPLETE:
            return "complete";
        case self::STATE_NOT_RUN:
            return "not run";
        case self::STATE_TIMEOUT:
            return "timeout";
        case self::STATE_MAX_INPUTS_REACHED:
            return "max valid input attempts reached";
        default:
            return "???";
        }
    }

    /**
     * A classic!
     *
     * @return string
     */
    public function __toString()
    {
        return
            "[ Node: " . $this->_name
            . " input: (" . $this->_input . ") "
            . " state: (" . $this->stateToString() . ")"
            . "]"
        ;
    }
}
