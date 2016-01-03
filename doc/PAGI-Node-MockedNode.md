PAGI\Node\MockedNode
===============

A Mocked node. Useful for testing ivr applications.




* Class name: MockedNode
* Namespace: PAGI\Node
* Parent class: [PAGI\Node\Node](PAGI-Node-Node.md)



Constants
----------


### DTMF_ANY

    const DTMF_ANY = '0123456789*#'





### DTMF_STAR

    const DTMF_STAR = '*'





### DTMF_HASH

    const DTMF_HASH = '#'





### DTMF_NUMERIC

    const DTMF_NUMERIC = '1234567890'





### DTMF_NONNUMERIC

    const DTMF_NONNUMERIC = '#*'





### DTMF_1

    const DTMF_1 = '1'





### DTMF_2

    const DTMF_2 = '2'





### DTMF_3

    const DTMF_3 = '3'





### DTMF_4

    const DTMF_4 = '4'





### DTMF_5

    const DTMF_5 = '5'





### DTMF_6

    const DTMF_6 = '6'





### DTMF_7

    const DTMF_7 = '7'





### DTMF_8

    const DTMF_8 = '8'





### DTMF_9

    const DTMF_9 = '9'





### DTMF_0

    const DTMF_0 = '0'





### DTMF_NONE

    const DTMF_NONE = ''





### STATE_NOT_RUN

    const STATE_NOT_RUN = 1





### STATE_CANCEL

    const STATE_CANCEL = 2





### STATE_COMPLETE

    const STATE_COMPLETE = 3





### STATE_TIMEOUT

    const STATE_TIMEOUT = 4





### STATE_MAX_INPUTS_REACHED

    const STATE_MAX_INPUTS_REACHED = 5





### INPUT_END

    const INPUT_END = 1





### INPUT_CANCEL

    const INPUT_CANCEL = 2





### INPUT_NORMAL

    const INPUT_NORMAL = 3





### TIME_INFINITE

    const TIME_INFINITE = -1





Properties
----------


### $mockedInput

    private string $mockedInput = array()

The complete input digit chain for this node.



* Visibility: **private**


### $expectedSay

    private array<mixed,string> $expectedSay = array()

The expected number of times that prompt messages need to be played
(keys are pagi client method names).



* Visibility: **private**


### $doneSay

    private array<mixed,string> $doneSay = array()

The counter of prompt messages actually played
(keys are pagi client method names).



* Visibility: **private**


### $expectedState

    private integer $expectedState = \PAGI\Node\Node::STATE_NOT_RUN

Default expected state.



* Visibility: **private**


### $validInputCallback

    private \PAGI\Node\Closure $validInputCallback = null

Optional callback to be used before executing the onInputValid callback.



* Visibility: **private**


### $failedInputCallback

    private \PAGI\Node\Closure $failedInputCallback = null

Optional callback to be used before executing the onInputFailed callback.



* Visibility: **private**


### $client

    private \PAGI\Client\IClient $client = null

Holds the PAGI client.



* Visibility: **private**


### $input

    private string $input = self::DTMF_NONE

Here's where the user input is appended one digit at the time.



* Visibility: **private**


### $state

    protected integer $state = self::STATE_NOT_RUN

Node state.



* Visibility: **protected**


### $endOfInputDigit

    private string $endOfInputDigit = 'X'

Holds the configured end of input digit.



* Visibility: **private**


### $cancelDigit

    private string $cancelDigit = 'X'

Holds the configured cancel digit.



* Visibility: **private**


### $minInput

    private integer $minInput

The minimum configured expected input length.



* Visibility: **private**


### $maxInput

    private integer $maxInput

The maximum configured expected input length.



* Visibility: **private**


### $timeBetweenDigits

    private integer $timeBetweenDigits = self::TIME_INFINITE

In milliseconds, maximum time to wait for user input between digits.

Only taken into account when expecting input outside prompt and preprompt
messages.

* Visibility: **private**


### $totalTimeForInput

    private integer $totalTimeForInput = self::TIME_INFINITE

In milliseconds, maximum time to wait for a complete user input (per
attempt).



* Visibility: **private**


### $promptMessages

    private array<mixed,string> $promptMessages = array()

Holds the prompt messages (actions) to be used before expecting the user
input (like sounds, numbers, datetimes, etc).



* Visibility: **private**


### $prePromptMessages

    private array<mixed,string> $prePromptMessages = array()

Similar to prompt messages, but dynamically populated and cleared with
pre prompt messages, like error messages from validations.



* Visibility: **private**


### $prePromptMessagesInterruptable

    private boolean $prePromptMessagesInterruptable = true

True if the pre prompt messages can be interrupted with a dtmf digit.



* Visibility: **private**


### $acceptPrePromptInputAsInput

    private boolean $acceptPrePromptInputAsInput = true

When the user can interrupt the pre prompt messages, this will indicate
if the digit pressed count as input (thus, discarding the prompt
messages).



* Visibility: **private**


### $name

    private string $name = 'X'

Node name.



* Visibility: **private**


### $inputValidations

    private array<mixed,\Closure> $inputValidations = array()

Holds all input validators.



* Visibility: **private**


### $totalAttemptsForInput

    private integer $totalAttemptsForInput = 1

Total attempts for the user to enter a valid input. Will loop input
routine this many times when the input is not validated.



* Visibility: **private**


### $onNoInputMessage

    private string $onNoInputMessage = null

Optional message to play when the user did not enter any digits on
input.



* Visibility: **private**


### $onMaxValidInputAttempts

    private string $onMaxValidInputAttempts = null

Optinal message to play when the user exceeded the maximum allowed
attempts to enter a valid input.



* Visibility: **private**


### $promptsCanBeInterrupted

    private boolean $promptsCanBeInterrupted = true

True if prompt messages can be interrupted.



* Visibility: **private**


### $validInterruptDigits

    private string $validInterruptDigits = self::DTMF_ANY

When pre prompt or prompt messages can be interrupted, these are the
valid interrupt digits.



* Visibility: **private**


### $registry

    private array<mixed,mixed> $registry = array()

Carries state. This is where optional custom data can be saved in the
callbacks and 3rd party software. Keys are strings.



* Visibility: **private**


### $executeOnValidInput

    private \Closure $executeOnValidInput = null

Callback to execute on valid input from the user.



* Visibility: **private**


### $executeOnInputFailed

    private \Closure $executeOnInputFailed = null

Callback to execute when the node failed to correctly
Enter description here .

..

* Visibility: **private**


### $cancelWithInputRetriesInput

    private boolean $cancelWithInputRetriesInput = false

When true, the user may retry the input by pressing the cancel button
if and only if he/she has already input one or more digits.



* Visibility: **private**


### $inputAttemptsUsed

    private integer $inputAttemptsUsed

Used to save the total amount of opportunities used to enter valid input.



* Visibility: **private**


### $executeBeforeRun

    private \Closure $executeBeforeRun = null

Execute before running this node.



* Visibility: **private**


### $executeAfterRun

    private \Closure $executeAfterRun = null

Execute after running this node.



* Visibility: **private**


### $executeAfterFailedValidation

    private \Closure $executeAfterFailedValidation = null

Execute after a validation has failed.



* Visibility: **private**


### $playOnNoInputInLastAttempt

    private boolean $playOnNoInputInLastAttempt = false

Play "no input" message in last attempt too.



* Visibility: **private**


Methods
-------


### assertSaySound

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertSaySound(string $filename, integer $totalTimes)

Configures this node to expect a given filename to be played n number
of times.



* Visibility: **public**


#### Arguments
* $filename **string**
* $totalTimes **integer**



### assertSayDigits

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertSayDigits(integer $digits, integer $totalTimes)

Configures this node to expect the given digits to be played n number
of times.



* Visibility: **public**


#### Arguments
* $digits **integer**
* $totalTimes **integer**



### assertSayNumber

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertSayNumber($number, integer $totalTimes)

Configures this node to expect the given number to be played n number
of times.



* Visibility: **public**


#### Arguments
* $number **mixed**
* $totalTimes **integer**



### assertSayDateTime

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertSayDateTime($time, $format, integer $totalTimes)

Configures this node to expect the given datetime to be played n number
of times with the given format.



* Visibility: **public**


#### Arguments
* $time **mixed**
* $format **mixed**
* $totalTimes **integer**



### recordDoneSay

    void PAGI\Node\MockedNode::recordDoneSay(string $what, array<mixed,string> $arguments)

Records a played prompt message with its arguments.



* Visibility: **protected**


#### Arguments
* $what **string** - &lt;p&gt;The pagi method name called.&lt;/p&gt;
* $arguments **array&lt;mixed,string&gt;** - &lt;p&gt;The arguments used, without the interrupt
digits.&lt;/p&gt;



### assertSay

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertSay(string $what, integer $totalTimes, array<mixed,string> $arguments)

Generic method to expect prompt messages played.



* Visibility: **protected**


#### Arguments
* $what **string** - &lt;p&gt;The pagi method name to expect.&lt;/p&gt;
* $totalTimes **integer** - &lt;p&gt;Total times to expect this call&lt;/p&gt;
* $arguments **array&lt;mixed,string&gt;** - &lt;p&gt;The arguments to assert.&lt;/p&gt;



### assertCancelled

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertCancelled()

Assert that this node is in state cancel after run().



* Visibility: **public**




### assertComplete

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertComplete()

Assert that this node is in state complete after run().



* Visibility: **public**




### assertMaxInputAttemptsReached

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::assertMaxInputAttemptsReached()

Assert that this node is in state of max input attempts reached
after run().



* Visibility: **public**




### runWithInput

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::runWithInput(string $digits)

Configure this node to mimic these digits as user input.



* Visibility: **public**


#### Arguments
* $digits **string**



### run

    \PAGI\Node\Node PAGI\Node\Node::run()

Executes this node.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### sayInterruptable

    void PAGI\Node\MockedNode::sayInterruptable(string $what, array $arguments)

Used to mimic the user input per prompt message.



* Visibility: **protected**


#### Arguments
* $what **string**
* $arguments **array**



### callClientMethods

    \PAGI\Client\Result\IResult PAGI\Node\Node::callClientMethods(array<mixed,\PAGI\Node\methodInfo> $methods, \Closure $stopWhen)

Calls methods in the PAGI client.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $methods **array&lt;mixed,\PAGI\Node\methodInfo&gt;** - &lt;p&gt;Methods to call, an array of arrays. The
second array has the method name as key and an array of arguments as
value.&lt;/p&gt;
* $stopWhen **Closure** - &lt;p&gt;If any, this callback is evaluated before
returning. Will return when false.&lt;/p&gt;



### doBeforeValidInput

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::doBeforeValidInput(\Closure $callback)

Execute a callback before invoking the real callback for valid input.



* Visibility: **public**


#### Arguments
* $callback **Closure**



### doBeforeFailedInput

    \PAGI\Node\MockedNode PAGI\Node\MockedNode::doBeforeFailedInput(\Closure $callback)

Execute a callback before invoking the real callback for failed input.



* Visibility: **public**


#### Arguments
* $callback **Closure**



### beforeOnValidInput

    void PAGI\Node\Node::beforeOnValidInput()

Convenient hook to execute before calling the onValidInput callback.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### beforeOnInputFailed

    void PAGI\Node\Node::beforeOnInputFailed()

Convenient hook to execute before calling the onInputFailed callback.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### prePromptMessagesNotInterruptable

    \PAGI\Node\Node PAGI\Node\Node::prePromptMessagesNotInterruptable()

Make pre prompt messages not interruptable



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### dontAcceptPrePromptInputAsInput

    \PAGI\Node\Node PAGI\Node\Node::dontAcceptPrePromptInputAsInput()

Digits entered during the pre prompt messages are not considered
as node input.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### unInterruptablePrompts

    \PAGI\Node\Node PAGI\Node\Node::unInterruptablePrompts()

Make prompt messages not interruptable.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### playOnNoInput

    \PAGI\Node\Node PAGI\Node\Node::playOnNoInput(string $filename)

Specify an optional message to play when the user did not enter any
input at all. By default, will NOT be played if this happens in the last
allowed attempt.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $filename **string** - &lt;p&gt;Sound file to play.&lt;/p&gt;



### playNoInputMessageOnLastAttempt

    \PAGI\Node\Node PAGI\Node\Node::playNoInputMessageOnLastAttempt()

Forces to play "no input" message on last attempt too.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### playOnMaxValidInputAttempts

    \PAGI\Node\Node PAGI\Node\Node::playOnMaxValidInputAttempts(string $filename)

Optional message to play when the user exhausted all the available
attempts to enter a valid input.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $filename **string** - &lt;p&gt;Sound file to play.&lt;/p&gt;



### maxAttemptsForInput

    \PAGI\Node\Node PAGI\Node\Node::maxAttemptsForInput(integer $number)

Specify a maximum attempt number for the user to enter a valid input.

Defaults to 1.

* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $number **integer**



### createValidatorInfo

    \PAGI\Node\validatorInfo PAGI\Node\Node::createValidatorInfo(\Closure $validation, string|null $soundOnError)

Given a callback and an optional sound to play on error, this will
return a validator information structure to be used with
validateInputWith().



* Visibility: **public**
* This method is **static**.
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $validation **Closure** - &lt;p&gt;Callback to use as validator&lt;/p&gt;
* $soundOnError **string|null** - &lt;p&gt;Sound file to play on error&lt;/p&gt;



### loadValidatorsFrom

    \PAGI\Node\Node PAGI\Node\Node::loadValidatorsFrom(array<mixed,\PAGI\Node\validatorInfo> $validatorsInformation)

Given an array of validator information structures, this will load
all validators into this node.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $validatorsInformation **array&lt;mixed,\PAGI\Node\validatorInfo&gt;**



### validateInputWith

    \PAGI\Node\Node PAGI\Node\Node::validateInputWith(string $name, \Closure $validation, string|null $soundOnError)

Add an input validation to this node.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $name **string** - &lt;p&gt;A distrinctive name for this validator&lt;/p&gt;
* $validation **Closure** - &lt;p&gt;Callback to use for validation&lt;/p&gt;
* $soundOnError **string|null** - &lt;p&gt;Optional sound to play on error&lt;/p&gt;



### validate

    boolean PAGI\Node\Node::validate()

Calls all validators in order. Will stop when any of them returns false.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### clearPromptMessages

    \PAGI\Node\Node PAGI\Node\Node::clearPromptMessages()

Removes prompt messages.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### addClientMethodCall

    void PAGI\Node\Node::addClientMethodCall()

Internally used to execute prompt messages in the agi client.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### addPrePromptClientMethodCall

    void PAGI\Node\Node::addPrePromptClientMethodCall()

Internally used to execute pre prompt messages in the agi client.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### addPrePromptMessage

    void PAGI\Node\Node::addPrePromptMessage(string $filename)

Adds a sound file to play as a pre prompt message.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $filename **string**



### sayDigits

    \PAGI\Node\Node PAGI\Node\Node::sayDigits(integer $digits)

Loads a prompt message for saying the digits of the given number.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digits **integer**



### sayNumber

    \PAGI\Node\Node PAGI\Node\Node::sayNumber(integer $number)

Loads a prompt message for saying a number.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $number **integer**



### sayDateTime

    \PAGI\Node\Node PAGI\Node\Node::sayDateTime(integer $timestamp, string $format)

Loads a prompt message for saying a date/time expressed by a unix
timestamp and a format.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $timestamp **integer**
* $format **string**



### saySound

    \PAGI\Node\Node PAGI\Node\Node::saySound(string $filename)

Loads a prompt message for playing an audio file.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $filename **string**



### expectAtLeast

    \PAGI\Node\Node PAGI\Node\Node::expectAtLeast(integer $length)

Configure the node to expect at least this many digits. The input is
considered complete when this many digits has been entered. Cancel and
end of input digits (if configured) are not taken into account.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $length **integer**



### expectAtMost

    \PAGI\Node\Node PAGI\Node\Node::expectAtMost(integer $length)

Configure the node to expect at most this many digits. The reading loop
will try to read this many digits.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $length **integer**



### expectExactly

    \PAGI\Node\Node PAGI\Node\Node::expectExactly(integer $length)

Configure this node to expect at least and at most this many digits.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $length **integer**



### cancelWith

    \PAGI\Node\Node PAGI\Node\Node::cancelWith(string $digit)

Configures a specific digit as the cancel digit.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digit **string** - &lt;p&gt;A single character, one of the DTMF_* constants.&lt;/p&gt;



### endInputWith

    \PAGI\Node\Node PAGI\Node\Node::endInputWith(string $digit)

Configures a specific digit as the end of input digit.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digit **string** - &lt;p&gt;A single character, one of the DTMF_* constants.&lt;/p&gt;



### maxTimeBetweenDigits

    \PAGI\Node\Node PAGI\Node\Node::maxTimeBetweenDigits(integer $milliseconds)

Configures the maximum time available between digits before a timeout.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $milliseconds **integer**



### maxTotalTimeForInput

    \PAGI\Node\Node PAGI\Node\Node::maxTotalTimeForInput(integer $milliseconds)

Configures the maximum time available for the user to enter valid input
per attempt.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $milliseconds **integer**



### inputLengthIsAtLeast

    boolean PAGI\Node\Node::inputLengthIsAtLeast(integer $length)

True if this node has at least this many digits entered.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $length **integer**



### hasInput

    boolean PAGI\Node\Node::hasInput()

True if this node has at least 1 digit as input, excluding cancel and
end of input digits.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### getInput

    string PAGI\Node\Node::getInput()

Returns input.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### getClient

    \PAGI\Client\IClient PAGI\Node\Node::getClient()

Returns the agi client in use.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### setName

    \PAGI\Node\Node PAGI\Node\Node::setName(string $name)

Gives a name for this node.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $name **string**



### setAgiClient

    \PAGI\Node\Node PAGI\Node\Node::setAgiClient(\PAGI\Client\IClient $client)

Sets the pagi client to use by this node.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $client **[PAGI\Client\IClient](PAGI-Client-IClient.md)**



### appendInput

    void PAGI\Node\Node::appendInput(string $digit)

Appends an input to the node input.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digit **string** - &lt;p&gt;A single character, one of the DTMF_* constants.&lt;/p&gt;



### inputIsCancel

    boolean PAGI\Node\Node::inputIsCancel(string $digit)

True if the digit matches the cancel digit.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digit **string** - &lt;p&gt;A single character, one of the DTMF_* constants.&lt;/p&gt;



### inputIsEnd

    boolean PAGI\Node\Node::inputIsEnd(string $digit)

True if the digit matches the end of input digit.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digit **string** - &lt;p&gt;A single character, one of the DTMF_* constants.&lt;/p&gt;



### evaluateInput

    integer PAGI\Node\Node::evaluateInput(string $digit)

Returns the kind of digit entered by the user, CANCEL, END, NORMAL.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digit **string** - &lt;p&gt;A single character, one of the DTMF_* constants.&lt;/p&gt;



### acceptInput

    void PAGI\Node\Node::acceptInput($digit)

Process a single digit input by the user. Changes the node state
according to the digit entered (CANCEL, COMPLETE).



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $digit **mixed**



### maxInputsReached

    boolean PAGI\Node\Node::maxInputsReached()

True if the user reached the maximum allowed attempts for valid input.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### wasCancelled

    boolean PAGI\Node\Node::wasCancelled()

True if this node is in CANCEL state.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### isTimeout

    boolean PAGI\Node\Node::isTimeout()

True if this node is in TIMEOUT state.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### isComplete

    boolean PAGI\Node\Node::isComplete()

True if this node is in COMPLETE state.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### callClientMethod

    \PAGI\Client\Result\IResult PAGI\Node\Node::callClientMethod(string $name, array<mixed,string> $arguments)

Call a specific method on a client.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $name **string**
* $arguments **array&lt;mixed,string&gt;**



### playPromptMessages

    \PAGI\Client\Result\IResult|null PAGI\Node\Node::playPromptMessages()

Plays pre prompt messages, like error messages from validations.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### clearPrePromptMessages

    void PAGI\Node\Node::clearPrePromptMessages()

Internally used to clear pre prompt messages after being played.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### playPrePromptMessages

    \PAGI\Client\Result\IResult PAGI\Node\Node::playPrePromptMessages()

Internally used to play all pre prompt queued messages. Clears the
queue after it.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### saveCustomData

    \PAGI\Node\Node PAGI\Node\Node::saveCustomData(string $key, mixed $value)

Saves a custom key/value to the registry.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $key **string**
* $value **mixed**



### getCustomData

    mixed PAGI\Node\Node::getCustomData(string $key)

Returns the value for the given key in the registry.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $key **string**



### hasCustomData

    boolean PAGI\Node\Node::hasCustomData(string $key)

True if the given key exists in the registry.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $key **string**



### delCustomData

    \PAGI\Node\Node PAGI\Node\Node::delCustomData(string $key)

Remove a key/value from the registry.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $key **string**



### cancelWithInputRetriesInput

    \PAGI\Node\Node PAGI\Node\Node::cancelWithInputRetriesInput()

Allow the user to retry input by pressing the cancel digit after entered
one or more digits. For example, when entering a 12 number pin, the user
might press the cancel digit at the 5th digit to re-enter it. This
counts as a failed input, but will not cancel the node. The node will be
cancelled only if the user presses the cancel digit with NO input at all.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### executeOnValidInput

    \PAGI\Node\Node PAGI\Node\Node::executeOnValidInput(\Closure $callback)

Specify a callback function to invoke when the user entered a valid
input.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $callback **Closure**



### executeOnInputFailed

    \PAGI\Node\Node PAGI\Node\Node::executeOnInputFailed(\Closure $callback)

Executes a callback when the node fails to properly get input from the
user (either because of cancel, max attempts reached, timeout).



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $callback **Closure**



### getTotalInputAttemptsUsed

    integer PAGI\Node\Node::getTotalInputAttemptsUsed()

Returns the total number of input attempts used by the user.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### resetInput

    \PAGI\Node\Node PAGI\Node\Node::resetInput()

Internally used to clear the input per input attempt. Also resets state
to TIMEOUT.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### doInput

    void PAGI\Node\Node::doInput()

Internally used to accept input from the user. Plays pre prompt messages,
prompt, and waits for a complete input or cancel.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### executeBeforeRun

    \PAGI\Node\Node PAGI\Node\Node::executeBeforeRun(\closure $callback)

Executes before running the node.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $callback **closure**



### executeAfterRun

    \PAGI\Node\Node PAGI\Node\Node::executeAfterRun(\Closure $callback)

Executes after running the node.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $callback **Closure**



### executeAfterFailedValidation

    \PAGI\Node\Node PAGI\Node\Node::executeAfterFailedValidation(\Closure $callback)

Executes after the 1st failed validation.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $callback **Closure**



### logDebug

    void PAGI\Node\Node::logDebug(string $msg)

Used internally to log debug messages



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $msg **string**



### getName

    string PAGI\Node\Node::getName()

Returns the node name.



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)




### stateToString

    string PAGI\Node\Node::stateToString(integer $state)

Maps the current node state to a human readable string.



* Visibility: **protected**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)


#### Arguments
* $state **integer** - &lt;p&gt;One of the STATE_* constants.&lt;/p&gt;



### __toString

    string PAGI\Node\Node::__toString()

A classic!



* Visibility: **public**
* This method is defined by [PAGI\Node\Node](PAGI-Node-Node.md)



