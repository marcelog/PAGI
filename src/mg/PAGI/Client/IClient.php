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
     * Logs to asterisk console.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function log($msg);

    /**
     * Retrieves channel status.
     *
     * @param string $channel Optional, channel name.
     *
     * @throws ChannelDownException
     * @return integer
     */
    public function channelStatus($channel = false);

    /**
     * Plays a file, can be interrupted by escapeDigits. Returns the digit
     * pressed (if any).
     *
     * @param string $file         File to play, without .wav extension.
     * @param string $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws SoundFileException
     * @throws ChannelDownException
     * @return integer
     */
    public function streamFile($file, $escapeDigits);

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
     * @return string
     */
    public function getData($file, $maxTime, $maxDigits, &$timeout = false);

    /**
     * Says digits. Uses agi command "SAY DIGITS". Returns the digit pressed
     * to skip the sound (false if none).
     *
     * @param string $digits       Number to say.
     * @param string $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * Enables/Disables the music on hold generator.
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
     * Cause the channel to automatically hangup at <time> seconds in the future.
     * Of course it can be hungup before then as well.
	 * Setting to 0 will cause the autohangup feature to be disabled on this channel.
	 *
     * @param integer $time Time to hangup channel.
     *
     * @return void
     */
    public function setAutoHangup($time);
}
