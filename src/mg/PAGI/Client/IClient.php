<?php
/**
 * AGI Client interface.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\Client;

/**
 * AGI Client interface.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
interface IClient
{
    /**
     * Returns an instance of ChannelVariables to access agi variables.
     *
     * @return IChannelVariables
     */
    public function getChannelVariables();

    /**
     * Returns a cdr facade.
     *
     * @return ICDR
     */
    public function getCDR();

    /**
     * Returns a caller id facade.
     *
     * @return ICallerID
     */
    public function getCallerId();

    /**
     * Logs to asterisk console. Uses agi command "VERBOSE".
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function log($msg);

    /**
     * Retrieves channel status. Uses agi command "CHANNEL STATUS"
     *
     * @param string $channel Optional, channel name.
     *
     * @throws ChannelDownException
     * @return integer
     */
    public function channelStatus($channel = false);

    /**
     * Plays a file, can be interrupted by escapeDigits. Returns the digit
     * pressed (if any). Uses agi command "STREAM FILE"
     *
     * @param string $file         File to play, without .wav extension.
     * @param string $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws SoundFileException
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function streamFile($file, $escapeDigits);

    /**
     * Waits up to <timeout> milliseconds for channel to receive a DTMF digit.
     * Returns a read result. Uses agi command "WAIT FOR DIGIT".
     *
     * @param integer $timeout Milliseconds to wait. -1 to block indefinitely.
     *
     * @throws ChannelDownException
     * @return DigitReadResult
     */
    public function waitDigit($timeout);

    /**
     * Reads input from user. Uses agi command "GET DATA". Returns the digits
     * pressed (false if none).
     *
     * @param string  $file         File to play.
     * @param integer $maxTime      Maximum time between digits before timeout.
     * @param string  $maxDigits    Maximum number of digits expected.
     * @param string  &$timeout     Will become true if the read aborted by
     * timeout.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function getData($file, $maxTime, $maxDigits);

    /**
     * Says digits. Uses agi command "SAY DIGITS". Returns the digit pressed
     * to skip the sound (false if none).
     *
     * @param string $digits       Number to say.
     * @param string $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function sayDigits($digits, $escapeDigits = '');

    /**
     * Says a number. Uses agi command "SAY NUMBER". Returns the digit pressed
     * to skip the sound (false if none).
     *
     * @param string $digits       Number to say.
     * @param string $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function sayNumber($digits, $escapeDigits = '');

    /**
     * Says time. Uses agi command "SAY TIME". Returns the digit pressed
     * to skip the sound (false if none).
     *
     * @param integer $time         Unix timestamp.
     * @param string  $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function sayTime($time, $escapeDigits = '');

    /**
     * Say a given date and time, returning early if any of the given DTMF
     * digits are received on the channel. Uses agi command "SAY DATETIME".
     * Returns the digit pressed to skip the sound (false if none).
     *
     * @param integer $time         Unix timestamp.
     * @param string  $format       Format the time should be said in.
     * @param string  $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function sayDateTime($time, $format, $escapeDigits = '');

    /**
     * Say a given date, returning early if any of the given DTMF
     * digits are received on the channel. Uses agi command "SAY DATE".
     * Returns the digit pressed to skip the sound (false if none).
     *
     * @param integer $time         Unix timestamp.
     * @param string  $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function sayDate($time, $escapeDigits = '');

    /**
     * Changes the priority for continuation upon exiting the application.
     * Uses agi command "SET PRIORITY".
     *
     * @param string $priority New priority.
     *
     * @return void
     */
    public function setPriority($priority);

    /**
     * Changes the extension for continuation upon exiting the application.
     * Uses agi command "SET EXTENSION".
     *
     * @param string $extension New extension.
     *
     * @return void
     */
    public function setExtension($extension);

    /**
     * Changes the context for continuation upon exiting the application.
     * Uses agi command "SET CONTEXT".
     *
     * @param string $context New context.
     *
     * @return void
     */
    public function setContext($context);

    /**
     * Changes the callerid of the current channel. Uses agi command
     * "SET CALLERID"
     *
     * @param string $name   CallerId name.
     * @param string $number CallerId number.
     *
     * @return void
     */
    public function setCallerId($name, $number);

    /**
     * Enables/Disables the music on hold generator. Uses agi command "SET MUSIC".
     *
     * @param boolean $enable True to enable, false to disable.
     * @param string  $class  If <class> is not specified then the default
     * music on hold class will be used.
     *
	 * @return void
     */
    public function setMusic($enable, $class = false);

    /**
     * Answers the current channel. Uses agi command "ANSWER".
     *
     * @throws ChannelDownException
     * @return void
     */
    public function answer();

    /**
     * Hangups the current channel. Uses agi command "HANGUP".
     *
     * @param string $channel Optional channel name.
     *
     * @throws ChannelDownException
     * @return void
     */
    public function hangup();

    /**
     * Returns a variable value. Uses agi command "GET VARIABLE". False if
     * variable is not set.
     *
     * @param string $name Variable name.
     *
     * @throws ChannelDownException
     * @return string
     */
    public function getVariable($name);

    /**
     * Returns a variable value. Uses agi command "GET FULL VARIABLE". False if
     * variable is not set.
     *
     * @param string $name    Variable name.
     * @param string $channel Optional channel name.
     *
     * @throws ChannelDownException
     * @return string
     */
    public function getFullVariable($name, $channel = false);

    /**
     * Sets a variable. Uses agi command "SET VARIABLE".
     *
     * @param string $name  Variable name.
     * @param string $value Variable value.
     *
     * @throws ChannelDownException
     * @return void
     */
    public function setVariable($name, $value);

    /**
     * Executes an application. Uses agi command "EXEC".
     *
     * @param string   $application Application name.
     * @param string[] $options     Application arguments.
     *
     * @throws ExecuteCommandException
     * @return string
     */
    public function exec($application, array $options = array());

    /**
     * Sends the given text on a channel. Uses agi command "SEND TEXT".
     *
     * @param string $text Text to send.
     *
     * @throws PAGIException
     * @return void
     */
    public function sendText($text);

    /**
     * Sends the given image on a channel. Uses agi command "SEND IMAGE".
     *
     * @param string $filename Image absolute path to send.
     *
     * @throws PAGIException
     * @return void
     */
    public function sendImage($filename);

    /**
     * Cause the channel to automatically hangup at <time> seconds in the future.
     * Of course it can be hungup before then as well.
	 * Setting to 0 will cause the autohangup feature to be disabled on this channel.
	 * Uses agi command "SET AUTOHANGUP".
	 *
     * @param integer $time Time to hangup channel.
     *
     * @return void
     */
    public function setAutoHangup($time);

    /**
     * Deletes an entry in the Asterisk database for a given family and key.
     * Uses agi command "DATABASE DEL".
     *
     * @param string $family Family for key.
     * @param string $key    Key name.
     *
     * @throws DatabaseInvalidEntryException
     * @return void
     */
    public function databaseDel($family, $key);

    /**
     * Deletes a family or specific keytree withing a family in the Asterisk database.
     * Uses agi command "DATABASE DELTREE".
     *
     * @param string $family Family for key.
     * @param string $key    Optional key name.
     *
     * @throws DatabaseInvalidEntryException
     * @return void
     */
    public function databaseDeltree($family, $key = false);

    /**
     * Retrieves an entry in the Asterisk database for a given family and key.
     * Uses agi command "DATABASE GET".
     *
     * @param string $family Family for key.
     * @param string $key    Key name.
     *
     * @throws DatabaseInvalidEntryException
     * @return string
     */
    public function databaseGet($family, $key);

    /**
     * Adds or updates an entry in the Asterisk database for a given family, key, and value.
     * Uses agi command "DATABASE PUT".
     *
     * @param string $family Family for key.
     * @param string $key    Key name.
     * @param string $value  Value to set.
     *
     * @throws DatabaseInvalidEntryException
     * @return void
     */
    public function databasePut($family, $key, $value);
}
