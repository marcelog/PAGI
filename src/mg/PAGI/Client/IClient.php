<?php
/**
 * AGI Client interface.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Exception
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
 * @package  Exception
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
    public function getCallerID();

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
     * @return integer
     */
    public function channelStatus($channel = false);

    public function streamFile($file, $escapeDigits);
    public function getData($file, $maxTime, $maxDigits, &$timeout = false, &$digits = false);
    public function sayDigits($digits, $escapeDigits = '');
    public function sayNumber($digits, $escapeDigits = '');

    /**
     * Answers the current channel. Uses agi command "ANSWER".
     *
     * @return void
     */
    public function answer();

    /**
     * Hangups the current channel. Uses agi command "HANGUP".
     *
     * @param string $channel Optional channel name.
     *
     * @return void
     */
    public function hangup();

    /**
     * Returns a variable value. Uses agi command "GET VARIABLE". False if
     * variable is not set.
     *
     * @param string $name Variable name.
     *
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
     * @return string
     */
    public function getFullVariable($name, $channel = false);

    /**
     * Sets a variable. Uses agi command "SET VARIABLE".
     *
     * @param string $name  Variable name.
     * @param string $value Variable value.
     *
     * @return void
     */
    public function setVariable($name, $value);
}
