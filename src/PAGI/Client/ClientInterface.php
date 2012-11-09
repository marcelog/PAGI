<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Client;

/**
 * AGI Client interface.
 */
interface ClientInterface
{
    /**
     * Returns an instance of ChannelVariables to access agi variables.
     *
     * @return \PAGI\ChannelVariables\ChannelVariablesInterface
     */
    public function getChannelVariables();

    /**
     * Returns a cdr facade.
     *
     * @return \PAGI\CDR\CDRInterface
     */
    public function getCDR();

    /**
     * Returns a caller id facade.
     *
     * @return \PAGI\CallerId\CallerIdInterface
     */
    public function getCallerId();

    /**
     * Logs to asterisk console. Uses agi command "VERBOSE".
     *
     * @param string $message Message to log
     */
    public function consoleLog($message);

    /**
     * Logs to asterisk logger. Uses application LOG.
     *
     * @param string $message  Message to log
     * @param string $priority One of ERROR, WARNING, NOTICE, DEBUG, VERBOSE, DTMF
     */
    public function log($message, $priority = 'NOTICE');

    /**
     * Returns an asterisk logger facade.
     *
     * @return \PAGI\Logger\AsteriskLoggerInterface
     */
    public function getAsteriskLogger();

    /**
     * Retrieves channel status. Uses agi command "CHANNEL STATUS"
     *
     * @param string $channel Optional, channel name
     *
     * @return integer
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function channelStatus($channel = false);

    /**
     * Plays a file, can be interrupted by escapeDigits.
     * Uses agi command "STREAM FILE"
     *
     * @param string $file         File to play, without .wav extension
     * @param string $escapeDigits Optional sequence of digits that can be used
     *                             to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\SoundFileException
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function streamFile($file, $escapeDigits);

    /**
     * Waits up to <timeout> milliseconds for channel to receive a DTMF digit.
     * Uses agi command "WAIT FOR DIGIT".
     *
     * @param integer $timeout Milliseconds to wait. -1 to block indefinitely
     *
     * @return \PAGI\Client\Result\DigitReadResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function waitDigit($timeout);

    /**
     * Reads input from user. Uses agi command "GET DATA".
     *
     * @param string  $file      File to play
     * @param integer $maxTime   Maximum time between digits before timeout
     * @param string  $maxDigits Maximum number of digits expected
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function getData($file, $maxTime, $maxDigits);

    /**
     * Reads input from user. Uses agi command "GET OPTION".
     *
     * @param string $file         File to play
     * @param string $escapeDigits Optional sequence of digits that can be used
     *                              to skip the sound
     * @param integer $maxTime Maximum time between digits before timeout
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function getOption($file, $escapeDigits, $maxTime);

    /**
     * Says digits. Uses agi command "SAY DIGITS".
     *
     * @param string $digits       Number to say
     * @param string $escapeDigits Optional sequence of digits that can be used
     *                             to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function sayDigits($digits, $escapeDigits = null);

    /**
     * Says a number. Uses agi command "SAY NUMBER".
     *
     * @param string $digits       Number to say
     * @param string $escapeDigits Optional sequence of digits that can be used
     *                             to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function sayNumber($digits, $escapeDigits = null);

    /**
     * Says time. Uses agi command "SAY TIME".
     *
     * @param integer $time         Unix timestamp
     * @param string  $escapeDigits Optional sequence of digits that can be used
     *                              to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function sayTime($time, $escapeDigits = null);

    /**
     * Say a given date and time, returning early if any of the given DTMF
     * digits are received on the channel. Uses agi command "SAY DATETIME".
     *
     * @param integer $time         Unix timestamp
     * @param string  $format       Format the time should be said in
     * @param string  $escapeDigits Optional sequence of digits that can be used
     *                              to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function sayDateTime($time, $format, $escapeDigits = null);

    /**
     * Say a given date, returning early if any of the given DTMF
     * digits are received on the channel. Uses agi command "SAY DATE".
     *
     * @param integer $time         Unix timestamp
     * @param string  $escapeDigits Optional sequence of digits that can be used
     *                              to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function sayDate($time, $escapeDigits = null);

    /**
     * Say a given character string with phonetics, returning early if any of
     * the given DTMF digits are received on the channel.
     * Uses agi command "SAY PHONETIC".
     *
     * @param string $what         What to say
     * @param string $escapeDigits Optional sequence of digits that can be used
     *                             to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function sayPhonetic($what, $escapeDigits = null);

    /**
     * Say a given character string, returning early if any of the given DTMF
     * digits are received on the channel. Uses agi command "SAY PHONETIC".
     *
     * @param string $what         What to say
     * @param string $escapeDigits Optional sequence of digits that can be used
     *                             to skip the sound
     *
     * @return \PAGI\Client\Result\PlayResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function sayAlpha($what, $escapeDigits = null);

    /**
     * Changes the priority for continuation upon exiting the application.
     * Uses agi command "SET PRIORITY".
     *
     * @param string $priority New priority
     */
    public function setPriority($priority);

    /**
     * Changes the extension for continuation upon exiting the application.
     * Uses agi command "SET EXTENSION".
     *
     * @param string $extension New extension
     */
    public function setExtension($extension);

    /**
     * Changes the context for continuation upon exiting the application.
     * Uses agi command "SET CONTEXT".
     *
     * @param string $context New context
     */
    public function setContext($context);

    /**
     * Changes the callerid of the current channel. Uses agi command
     * "SET CALLERID"
     *
     * @param string $name   CallerId name
     * @param string $number CallerId number
     */
    public function setCallerId($name, $number);

    /**
     * Enables/Disables the music on hold generator. Uses agi command "SET MUSIC".
     *
     * @param Boolean $enable True to enable, false to disable
     * @param string  $class  If <class> is not specified then the default
     *                        music on hold class will be used
     */
    public function setMusic($enable, $class = false);

    /**
     * Answers the current channel. Uses agi command "ANSWER".
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function answer();

    /**
     * Hangups the current channel. Uses agi command "HANGUP".
     *
     * @param string $channel Optional channel name
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function hangup();

    /**
     * Returns a variable value. Uses agi command "GET VARIABLE". False if
     * variable is not set.
     *
     * @param string $name Variable name
     *
     * @return string
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function getVariable($name);

    /**
     * Returns a variable value. Uses agi command "GET FULL VARIABLE". False if
     * variable is not set.
     *
     * @param string $name    Variable name
     * @param string $channel Optional channel name
     *
     * @return string
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function getFullVariable($name, $channel = false);

    /**
     * Sets a variable. Uses agi command "SET VARIABLE".
     *
     * @param string $name  Variable name
     * @param string $value Variable value
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function setVariable($name, $value);

    /**
     * Executes an application. Uses agi command "EXEC".
     *
     * @param string $application Application name
     * @param array  $options     Application arguments
     *
     * @return \PAGI\Client\Result\ExecResult
     *
     * @throws \PAGI\Exception\ExecuteCommandException
     */
    public function exec($application, array $options = array());

    /**
     * Sends the given text on a channel. Uses agi command "SEND TEXT".
     *
     * @param string $text Text to send
     *
     * @throws \PAGI\Exception\PAGIException
     */
    public function sendText($text);

    /**
     * Sends the given image on a channel. Uses agi command "SEND IMAGE".
     *
     * @param string $filename Image absolute path to send
     *
     * @throws \PAGI\Exception\PAGIException
     */
    public function sendImage($filename);

    /**
     * Cause the channel to automatically hangup at <time> seconds in the future.
     * Of course it can be hungup before then as well.
     * Setting to 0 will cause the autohangup feature to be disabled on this channel.
     * Uses agi command "SET AUTOHANGUP".
     *
     * @param integer $time Time to hangup channel
     */
    public function setAutoHangup($time);

    /**
     * Deletes an entry in the Asterisk database for a given family and key.
     * Uses agi command "DATABASE DEL".
     *
     * @param string $family Family for key
     * @param string $key    Key name
     *
     * @throws \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function databaseDel($family, $key);

    /**
     * Deletes a family or specific keytree withing a family in the Asterisk database.
     * Uses agi command "DATABASE DELTREE".
     *
     * @param string $family Family for key
     * @param string $key    Optional key name
     *
     * @throws \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function databaseDeltree($family, $key = false);

    /**
     * Retrieves an entry in the Asterisk database for a given family and key.
     * Uses agi command "DATABASE GET".
     *
     * @param string $family Family for key
     * @param string $key    Key name
     *
     * @return string
     *
     * @throws \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function databaseGet($family, $key);

    /**
     * Adds or updates an entry in the Asterisk database for a given family, key, and value.
     * Uses agi command "DATABASE PUT".
     *
     * @param string $family Family for key
     * @param string $key    Key name
     * @param string $value  Value to set
     *
     * @throws \PAGI\Exception\DatabaseInvalidEntryException
     */
    public function databasePut($family, $key, $value);

    /**
     * Record to a file until <escape digits> are received as dtmf.
     * Uses agi command "RECORD FILE".
     *
     * @param string $file         Target file, without the .wav (or extension chosen)
     * @param string $format       Format (wav, mp3, etc)
     * @param string $escapeDigits Optional sequence of digits that can be used
     *                               to skip the sound
     * @param integer $maxRecordTime Maximum record time (optional)
     * @param integer $silence       Maximum time of silence allowed (optional)
     *
     * @return \PAGI\Client\Result\RecordResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function record($file, $format, $escapeDigits, $maxRecordTime = -1, $silence = false);

    /**
     * Tries to dial the given channel.
     *
     * @param string $channel What to dial
     * @param array  $options Dial app options
     *
     * @return \PAGI\Client\Result\DialResult
     *
     * @throws \PAGI\Exception\ChannelDownException
     */
    public function dial($channel, array $options = array());

    /**
     * Sends a fax.
     *
     * @param string $tiffFile Absolute path to a .tiff file
     *
     * @return \PAGI\Client\Result\FaxResult
     */
    public function faxSend($tiffFile);

    /**
     * Receives a fax.
     *
     * @param string $tiffFile Absolute path to a .tiff file
     *
     * @return \PAGI\Client\Result\FaxResult
     */
    public function faxReceive($tiffFile);

    /**
     * Indicates progress of a call, starting early audio.
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function indicateProgress();

    /**
     * Indicates busy and waits for hangup. Does not play a busy tone.
     *
     * @param integer $timeout Time in seconds to wait for hangup
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function indicateBusy($timeout);

    /**
     * Indicates congestion and waits for hangup. Does not play a busy tone.
     *
     * @param integer $timeout Time in seconds to wait for hangup
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function indicateCongestion($timeout);

    /**
     * Plays a tone defined in indications.conf.
     *
     * @param string $tone Tone to play
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function playTone($tone);

    /**
     * Plays a customized frequency tone.
     *
     * @param array $frequencies Frequencies for the tone: 425/50,0/50 or
     *                           !950/330,!1400/330,!1800/330,0 etc
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function playCustomTones(array $frequencies = array());

    /**
     * Stop playing current played tones.
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function stopPlayingTones();

    /**
     * Plays "Dial" tone, defined in indications.conf
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function playDialTone();

    /**
     * Plays "Busy" tone, defined in indications.conf
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function playBusyTone();

    /**
     * Plays "Congestion" tone, defined in indications.conf
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function playCongestionTone();

    /**
     * Convenient method to create a node.
     *
     * @param string $name
     *
     * @return \PAGI\Node\Node
     */
    public function createNode($name);

    /**
     * Adds a SIP header to the first invite message in a dial command.
     *
     * @param string $name
     * @param string $value
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function sipHeaderAdd($name, $value);

    /**
     * Removes a header previously added with sipHeaderAdd.
     *
     * @param string $name
     *
     * @return \PAGI\Client\Result\ExecResult
     */
    public function sipHeaderRemove($name);

    /**
     * Creates a new node controller.
     *
     * @param string $name
     *
     * @return \PAGI\Node\NodeController
     */
    public function createNodeController($name);

    /**
     * Runs the AMD() application. For a complete list of options see:
     * https://wiki.asterisk.org/wiki/display/AST/Application_AMD
     *
     * @param array $options
     *
     * @return \PAGI\Client\Result\AmdResult
     */
    public function amd(array $options = array());
}
