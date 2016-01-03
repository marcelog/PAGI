PAGI\Client\Impl\MockedClientImpl
===============

An AGI client implementation useful for mocking and testing ivr apps.

PHP Version 5


* Class name: MockedClientImpl
* Namespace: PAGI\Client\Impl
* Parent class: [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)





Properties
----------


### $mockedResultStrings

    private array<mixed,string> $mockedResultStrings

Mocked result strings.



* Visibility: **private**


### $methodCallAsserts

    private mixed $methodCallAsserts = array()





* Visibility: **private**


### $logger

    protected \PAGI\Client\Logger $logger

PSR-3 logger.



* Visibility: **protected**


### $variables

    protected array<mixed,string> $variables = array()

Initial channel variables given by asterisk at start.



* Visibility: **protected**


### $arguments

    protected array<mixed,string> $arguments = array()

Initial arguments given by the user in the dialplan.



* Visibility: **protected**


### $cdrInstance

    protected mixed $cdrInstance = false





* Visibility: **protected**


### $channelVariablesInstance

    protected mixed $channelVariablesInstance = false





* Visibility: **protected**


### $clidInstance

    protected mixed $clidInstance = false





* Visibility: **protected**


Methods
-------


### send

    \PAGI\Client\Result\Result PAGI\Client\AbstractClient::send(string $text)

Sends a command to asterisk. Returns an array with:
[0] => AGI Result (3 digits)
[1] => Command result
[2] => Result data.



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)


#### Arguments
* $text **string** - &lt;p&gt;Command&lt;/p&gt;



### open

    void PAGI\Client\AbstractClient::open()

Opens connection to agi. Will also read initial channel variables given
by asterisk when launching the agi.



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)




### close

    void PAGI\Client\AbstractClient::close()

Closes the connection to agi.



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)




### __destruct

    mixed PAGI\Client\Impl\MockedClientImpl::__destruct()





* Visibility: **public**




### addMockedResult

    mixed PAGI\Client\Impl\MockedClientImpl::addMockedResult($string)





* Visibility: **public**


#### Arguments
* $string **mixed**



### assert

    mixed PAGI\Client\Impl\MockedClientImpl::assert($methodName, array $args)





* Visibility: **public**


#### Arguments
* $methodName **mixed**
* $args **array**



### assertCall

    mixed PAGI\Client\Impl\MockedClientImpl::assertCall($methodName, array $arguments)





* Visibility: **private**


#### Arguments
* $methodName **mixed**
* $arguments **array**



### channelStatus

    integer PAGI\Client\IClient::channelStatus(string $channel)

Retrieves channel status. Uses agi command "CHANNEL STATUS"



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $channel **string** - &lt;p&gt;Optional, channel name.&lt;/p&gt;



### waitDigit

    \PAGI\Client\Result\DigitReadResult PAGI\Client\IClient::waitDigit(integer $timeout)

Waits up to <timeout> milliseconds for channel to receive a DTMF digit.

Uses agi command "WAIT FOR DIGIT".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $timeout **integer** - &lt;p&gt;Milliseconds to wait. -1 to block indefinitely.&lt;/p&gt;



### streamFile

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::streamFile(string $file, string $escapeDigits)

Plays a file, can be interrupted by escapeDigits.

Uses agi command "STREAM FILE"

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $file **string** - &lt;p&gt;File to play, without .wav extension.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### dial

    \PAGI\Client\Result\DialResult PAGI\Client\IClient::dial(string $channel, array<mixed,string> $options)

Tries to dial the given channel.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $channel **string** - &lt;p&gt;What to dial.&lt;/p&gt;
* $options **array&lt;mixed,string&gt;** - &lt;p&gt;Dial app options&lt;/p&gt;



### getData

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::getData(string $file, integer $maxTime, string $maxDigits)

Reads input from user. Uses agi command "GET DATA".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $file **string** - &lt;p&gt;File to play.&lt;/p&gt;
* $maxTime **integer** - &lt;p&gt;Maximum time between digits before timeout.&lt;/p&gt;
* $maxDigits **string** - &lt;p&gt;Maximum number of digits expected.&lt;/p&gt;



### record

    \PAGI\Client\Result\RecordResult PAGI\Client\IClient::record(string $file, string $format, string $escapeDigits, integer $maxRecordTime, integer $silence)

Record to a file until <escape digits> are received as dtmf.

Uses agi command "RECORD FILE".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $file **string** - &lt;p&gt;Target file, without the .wav (or extension
chosen).&lt;/p&gt;
* $format **string** - &lt;p&gt;Format (wav, mp3, etc).&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;
* $maxRecordTime **integer** - &lt;p&gt;Maximum record time (optional).&lt;/p&gt;
* $silence **integer** - &lt;p&gt;Maximum time of silence allowed (optional)&lt;/p&gt;



### sayTime

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::sayTime(integer $time, string $escapeDigits)

Says time. Uses agi command "SAY TIME".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $time **integer** - &lt;p&gt;Unix timestamp.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### sayDate

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::sayDate(integer $time, string $escapeDigits)

Say a given date, returning early if any of the given DTMF
digits are received on the channel. Uses agi command "SAY DATE".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $time **integer** - &lt;p&gt;Unix timestamp.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### sayDateTime

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::sayDateTime(integer $time, string $format, string $escapeDigits)

Say a given date and time, returning early if any of the given DTMF
digits are received on the channel. Uses agi command "SAY DATETIME".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $time **integer** - &lt;p&gt;Unix timestamp.&lt;/p&gt;
* $format **string** - &lt;p&gt;Format the time should be said in.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### sayDigits

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::sayDigits(string $digits, string $escapeDigits)

Says digits. Uses agi command "SAY DIGITS".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $digits **string** - &lt;p&gt;Number to say.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### sayNumber

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::sayNumber(string $digits, string $escapeDigits)

Says a number. Uses agi command "SAY NUMBER".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $digits **string** - &lt;p&gt;Number to say.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### sayAlpha

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::sayAlpha(string $what, string $escapeDigits)

Say a given character string, returning early if any of the given DTMF
digits are received on the channel. Uses agi command "SAY PHONETIC".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $what **string** - &lt;p&gt;What to say.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### sayPhonetic

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::sayPhonetic(string $what, string $escapeDigits)

Say a given character string with phonetics, returning early if any of
the given DTMF digits are received on the channel.

Uses agi command "SAY PHONETIC".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $what **string** - &lt;p&gt;What to say.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;



### getFullVariable

    string PAGI\Client\IClient::getFullVariable(string $name, string $channel)

Returns a variable value. Uses agi command "GET FULL VARIABLE". False if
variable is not set.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string** - &lt;p&gt;Variable name.&lt;/p&gt;
* $channel **string** - &lt;p&gt;Optional channel name.&lt;/p&gt;



### getVariable

    string PAGI\Client\IClient::getVariable(string $name)

Returns a variable value. Uses agi command "GET VARIABLE". False if
variable is not set.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string** - &lt;p&gt;Variable name.&lt;/p&gt;



### setVariable

    void PAGI\Client\IClient::setVariable(string $name, string $value)

Sets a variable. Uses agi command "SET VARIABLE".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string** - &lt;p&gt;Variable name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Variable value.&lt;/p&gt;



### consoleLog

    void PAGI\Client\IClient::consoleLog(string $msg)

Logs to asterisk console. Uses agi command "VERBOSE".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### log

    void PAGI\Client\IClient::log(string $msg, string $priority)

Logs to asterisk logger. Uses application LOG.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;
* $priority **string** - &lt;p&gt;One of ERROR, WARNING, NOTICE, DEBUG, VERBOSE, DTMF&lt;/p&gt;



### getOption

    \PAGI\Client\Result\PlayResult PAGI\Client\IClient::getOption(string $file, string $escapeDigits, integer $maxTime)

Reads input from user. Uses agi command "GET OPTION".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $file **string** - &lt;p&gt;File to play.&lt;/p&gt;
* $escapeDigits **string** - &lt;p&gt;Optional sequence of digits that can be used
to skip the sound.&lt;/p&gt;
* $maxTime **integer** - &lt;p&gt;Maximum time between digits before timeout.&lt;/p&gt;



### setCallerId

    void PAGI\Client\IClient::setCallerId(string $name, string $number)

Changes the callerid of the current channel. Uses agi command
"SET CALLERID"



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string** - &lt;p&gt;CallerId name.&lt;/p&gt;
* $number **string** - &lt;p&gt;CallerId number.&lt;/p&gt;



### playBusyTone

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::playBusyTone()

Plays "Busy" tone, defined in indications.conf



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### playCongestionTone

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::playCongestionTone()

Plays "Congestion" tone, defined in indications.conf



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### playDialTone

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::playDialTone()

Plays "Dial" tone, defined in indications.conf



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### stopPlayingTones

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::stopPlayingTones()

Stop playing current played tones.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### playCustomTones

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::playCustomTones(array<mixed,string> $frequencies)

Plays a customized frequency tone.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $frequencies **array&lt;mixed,string&gt;** - &lt;p&gt;Frequencies for the tone: 425/50,0/50 or
!950/330,!1400/330,!1800/330,0 etc.&lt;/p&gt;



### playTone

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::playTone(string $tone)

Plays a tone defined in indications.conf.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $tone **string** - &lt;p&gt;Tone to play&lt;/p&gt;



### setPriority

    void PAGI\Client\IClient::setPriority(string $priority)

Changes the priority for continuation upon exiting the application.

Uses agi command "SET PRIORITY".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $priority **string** - &lt;p&gt;New priority.&lt;/p&gt;



### setContext

    void PAGI\Client\IClient::setContext(string $context)

Changes the context for continuation upon exiting the application.

Uses agi command "SET CONTEXT".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $context **string** - &lt;p&gt;New context.&lt;/p&gt;



### setExtension

    void PAGI\Client\IClient::setExtension(string $extension)

Changes the extension for continuation upon exiting the application.

Uses agi command "SET EXTENSION".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $extension **string** - &lt;p&gt;New extension.&lt;/p&gt;



### setMusic

    void PAGI\Client\IClient::setMusic(boolean $enable, string $class)

Enables/Disables the music on hold generator. Uses agi command "SET MUSIC".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $enable **boolean** - &lt;p&gt;True to enable, false to disable.&lt;/p&gt;
* $class **string** - &lt;p&gt;If &lt;class&gt; is not specified then the default
music on hold class will be used.&lt;/p&gt;



### amd

    \PAGI\Client\Result\AmdResult PAGI\Client\IClient::amd(array<mixed,string> $options)

Runs the AMD() application. For a complete list of options see:
https://wiki.asterisk.org/wiki/display/AST/Application_AMD



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $options **array&lt;mixed,string&gt;**



### answer

    void PAGI\Client\IClient::answer()

Answers the current channel. Uses agi command "ANSWER".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### hangup

    void PAGI\Client\IClient::hangup()

Hangups the current channel. Uses agi command "HANGUP".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### onGetOption

    mixed PAGI\Client\Impl\MockedClientImpl::onGetOption($interrupted, $digit, $offset)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**
* $offset **mixed**



### onWaitDigit

    mixed PAGI\Client\Impl\MockedClientImpl::onWaitDigit($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onGetVariable

    mixed PAGI\Client\Impl\MockedClientImpl::onGetVariable($success, $value)





* Visibility: **public**


#### Arguments
* $success **mixed**
* $value **mixed**



### onGetFullVariable

    mixed PAGI\Client\Impl\MockedClientImpl::onGetFullVariable($success, $value)





* Visibility: **public**


#### Arguments
* $success **mixed**
* $value **mixed**



### onChannelStatus

    mixed PAGI\Client\Impl\MockedClientImpl::onChannelStatus($status)





* Visibility: **public**


#### Arguments
* $status **mixed**



### onDial

    mixed PAGI\Client\Impl\MockedClientImpl::onDial($success, $peerName, $peerNumber, $answeredTime, $dialStatus, $dynamicFeatures)





* Visibility: **public**


#### Arguments
* $success **mixed**
* $peerName **mixed**
* $peerNumber **mixed**
* $answeredTime **mixed**
* $dialStatus **mixed**
* $dynamicFeatures **mixed**



### onRecord

    mixed PAGI\Client\Impl\MockedClientImpl::onRecord($interrupted, $hangup, $digit, $endpos)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $hangup **mixed**
* $digit **mixed**
* $endpos **mixed**



### onStreamFile

    mixed PAGI\Client\Impl\MockedClientImpl::onStreamFile($interrupted, $digit, $offset)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**
* $offset **mixed**



### onGetData

    mixed PAGI\Client\Impl\MockedClientImpl::onGetData($interrupted, $digits)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digits **mixed**



### onSayTime

    mixed PAGI\Client\Impl\MockedClientImpl::onSayTime($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onSayDateTime

    mixed PAGI\Client\Impl\MockedClientImpl::onSayDateTime($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onSayDate

    mixed PAGI\Client\Impl\MockedClientImpl::onSayDate($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onSayNumber

    mixed PAGI\Client\Impl\MockedClientImpl::onSayNumber($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onSayDigits

    mixed PAGI\Client\Impl\MockedClientImpl::onSayDigits($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onSayPhonetic

    mixed PAGI\Client\Impl\MockedClientImpl::onSayPhonetic($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onSayAlpha

    mixed PAGI\Client\Impl\MockedClientImpl::onSayAlpha($interrupted, $digit)





* Visibility: **public**


#### Arguments
* $interrupted **mixed**
* $digit **mixed**



### onAnswer

    mixed PAGI\Client\Impl\MockedClientImpl::onAnswer($success)





* Visibility: **public**


#### Arguments
* $success **mixed**



### onHangup

    mixed PAGI\Client\Impl\MockedClientImpl::onHangup($success)





* Visibility: **public**


#### Arguments
* $success **mixed**



### onAmd

    mixed PAGI\Client\Impl\MockedClientImpl::onAmd($status, $cause)





* Visibility: **public**


#### Arguments
* $status **mixed**
* $cause **mixed**



### onCreateNode

    mixed PAGI\Client\Impl\MockedClientImpl::onCreateNode($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### createNode

    \PAGI\Node\Node PAGI\Client\IClient::createNode(string $name)

Convenient method to create a node.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string**



### getAsteriskLogger

    \PAGI\Logger\Asterisk\IAsteriskLogger PAGI\Client\IClient::getAsteriskLogger()

Returns an asterisk logger facade.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### getLogger

    mixed PAGI\Client\Impl\MockedClientImpl::getLogger()





* Visibility: **public**




### __construct

    mixed PAGI\Client\Impl\MockedClientImpl::__construct(array $options)





* Visibility: **public**


#### Arguments
* $options **array**



### getResultFromResultString

    \PAGI\Client\Result\Result PAGI\Client\AbstractClient::getResultFromResultString(\PAGI\Client\unknown_type $text)

Returns a result object given a string (the agi result after executing
a command).



* Visibility: **protected**
* This method is defined by [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)


#### Arguments
* $text **PAGI\Client\unknown_type**



### faxSend

    \PAGI\Client\Result\FaxResult PAGI\Client\IClient::faxSend(string $tiffFile)

Sends a fax.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $tiffFile **string** - &lt;p&gt;Absolute path to a .tiff file.&lt;/p&gt;



### faxReceive

    \PAGI\Client\Result\FaxResult PAGI\Client\IClient::faxReceive(string $tiffFile)

Receives a fax.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $tiffFile **string** - &lt;p&gt;Absolute path to a .tiff file.&lt;/p&gt;



### exec

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::exec(string $application, array<mixed,string> $options)

Executes an application. Uses agi command "EXEC".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $application **string** - &lt;p&gt;Application name.&lt;/p&gt;
* $options **array&lt;mixed,string&gt;** - &lt;p&gt;Application arguments.&lt;/p&gt;



### setAutoHangup

    void PAGI\Client\IClient::setAutoHangup(integer $time)

Cause the channel to automatically hangup at <time> seconds in the future.

Of course it can be hungup before then as well.
Setting to 0 will cause the autohangup feature to be disabled on this channel.
Uses agi command "SET AUTOHANGUP".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $time **integer** - &lt;p&gt;Time to hangup channel.&lt;/p&gt;



### playAndRead

    mixed PAGI\Client\AbstractClient::playAndRead($cmd)





* Visibility: **private**
* This method is defined by [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)


#### Arguments
* $cmd **mixed**



### databaseDel

    void PAGI\Client\IClient::databaseDel(string $family, string $key)

Deletes an entry in the Asterisk database for a given family and key.

Uses agi command "DATABASE DEL".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $family **string** - &lt;p&gt;Family for key.&lt;/p&gt;
* $key **string** - &lt;p&gt;Key name.&lt;/p&gt;



### databaseDeltree

    void PAGI\Client\IClient::databaseDeltree(string $family, string $key)

Deletes a family or specific keytree withing a family in the Asterisk database.

Uses agi command "DATABASE DELTREE".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $family **string** - &lt;p&gt;Family for key.&lt;/p&gt;
* $key **string** - &lt;p&gt;Optional key name.&lt;/p&gt;



### databaseGet

    string PAGI\Client\IClient::databaseGet(string $family, string $key)

Retrieves an entry in the Asterisk database for a given family and key.

Uses agi command "DATABASE GET".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $family **string** - &lt;p&gt;Family for key.&lt;/p&gt;
* $key **string** - &lt;p&gt;Key name.&lt;/p&gt;



### databasePut

    void PAGI\Client\IClient::databasePut(string $family, string $key, string $value)

Adds or updates an entry in the Asterisk database for a given family, key, and value.

Uses agi command "DATABASE PUT".

* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $family **string** - &lt;p&gt;Family for key.&lt;/p&gt;
* $key **string** - &lt;p&gt;Key name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### sendText

    void PAGI\Client\IClient::sendText(string $text)

Sends the given text on a channel. Uses agi command "SEND TEXT".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $text **string** - &lt;p&gt;Text to send.&lt;/p&gt;



### sendImage

    void PAGI\Client\IClient::sendImage(string $filename)

Sends the given image on a channel. Uses agi command "SEND IMAGE".



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $filename **string** - &lt;p&gt;Image absolute path to send.&lt;/p&gt;



### isEndOfEnvironmentVariables

    boolean PAGI\Client\AbstractClient::isEndOfEnvironmentVariables(string $line)

Returns true if the current line marks the end of the environment variables.



* Visibility: **protected**
* This method is defined by [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)


#### Arguments
* $line **string**



### readEnvironmentVariable

    void PAGI\Client\AbstractClient::readEnvironmentVariable(string $line)

Will read and save an environment variable as either a variable or an argument.



* Visibility: **protected**
* This method is defined by [PAGI\Client\AbstractClient](PAGI-Client-AbstractClient.md)


#### Arguments
* $line **string**



### getChannelVariables

    \PAGI\ChannelVariables\IChannelVariables PAGI\Client\IClient::getChannelVariables()

Returns an instance of ChannelVariables to access agi variables.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### getCDR

    \PAGI\CDR\ICDR PAGI\Client\IClient::getCDR()

Returns a cdr facade.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### getCallerId

    \PAGI\Client\ICallerID PAGI\Client\IClient::getCallerId()

Returns a caller id facade.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### indicateProgress

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::indicateProgress()

Indicates progress of a call, starting early audio.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)




### indicateBusy

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::indicateBusy(integer $timeout)

Indicates busy and waits for hangup. Does not play a busy tone.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $timeout **integer** - &lt;p&gt;Time in seconds to wait for hangup&lt;/p&gt;



### indicateCongestion

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::indicateCongestion(integer $timeout)

Indicates congestion and waits for hangup. Does not play a busy tone.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $timeout **integer** - &lt;p&gt;Time in seconds to wait for hangup&lt;/p&gt;



### sipHeaderAdd

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::sipHeaderAdd(string $name, string $value)

Adds a SIP header to the first invite message in a dial command.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string**
* $value **string**



### sipHeaderRemove

    \PAGI\Client\Result\ExecResult PAGI\Client\IClient::sipHeaderRemove(string $name)

Removes a header previously added with sipHeaderAdd.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string**



### createNodeController

    \PAGI\Node\NodeController PAGI\Client\IClient::createNodeController(string $name)

Creates a new node controller.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $name **string**



### setLogger

    void PAGI\Client\IClient::setLogger(\PAGI\Client\Psr\Log\LoggerInterface $logger)

Sets the logger implementation.



* Visibility: **public**
* This method is defined by [PAGI\Client\IClient](PAGI-Client-IClient.md)


#### Arguments
* $logger **PAGI\Client\Psr\Log\LoggerInterface** - &lt;p&gt;The PSR3-Logger&lt;/p&gt;


