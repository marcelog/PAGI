<?php
/**
 * AGI Client interface.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
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
namespace PAGI\Client;

/**
 * AGI Client interface.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
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
    public function consoleLog($msg);

    /**
     * Logs to asterisk logger. Uses application LOG.
     *
     * @param string $msg      Message to log.
     * @param string $priority One of ERROR, WARNING, NOTICE, DEBUG, VERBOSE, DTMF
     *
     * @return void
     */
    public function log($msg, $priority = 'NOTICE');

    /**
     * Returns an asterisk logger facade.
     *
     * @return IAsteriskLogger
     */
    public function getAsteriskLogger();

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
     * Plays a file, can be interrupted by escapeDigits.
     * Uses agi command "STREAM FILE"
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
     * Uses agi command "WAIT FOR DIGIT".
     *
     * @param integer $timeout Milliseconds to wait. -1 to block indefinitely.
     *
     * @throws ChannelDownException
     * @return DigitReadResult
     */
    public function waitDigit($timeout);

    /**
     * Reads input from user. Uses agi command "GET DATA".
     *
     * @param string  $file         File to play.
     * @param integer $maxTime      Maximum time between digits before timeout.
     * @param string  $maxDigits    Maximum number of digits expected.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function getData($file, $maxTime, $maxDigits);

    /**
     * Reads input from user. Uses agi command "GET OPTION".
     *
     * @param string  $file         File to play.
     * @param string  $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     * @param integer $maxTime      Maximum time between digits before timeout.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function getOption($file, $escapeDigits, $maxTime);

    /**
     * Says digits. Uses agi command "SAY DIGITS".
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
     * Says a number. Uses agi command "SAY NUMBER".
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
     * Says time. Uses agi command "SAY TIME".
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
     * Say a given character string with phonetics, returning early if any of
     * the given DTMF digits are received on the channel.
     * Uses agi command "SAY PHONETIC".
     *
     * @param string $what         What to say.
     * @param string $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function sayPhonetic($what, $escapeDigits = '');

    /**
     * Say a given character string, returning early if any of the given DTMF
     * digits are received on the channel. Uses agi command "SAY PHONETIC".
     *
     * @param string $what         What to say.
     * @param string $escapeDigits Optional sequence of digits that can be used
     * to skip the sound.
     *
     * @throws ChannelDownException
     * @return PlayResult
     */
    public function sayAlpha($what, $escapeDigits = '');

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
     * @return ExecResult
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

    /**
     * Record to a file until <escape digits> are received as dtmf.
     * Uses agi command "RECORD FILE".
     *
     * @param string  $file          Target file, without the .wav (or extension
     * chosen).
     * @param string  $format        Format (wav, mp3, etc).
     * @param string  $escapeDigits  Optional sequence of digits that can be used
     * to skip the sound.
     * @param integer $maxRecordTime Maximum record time (optional).
     * @param integer $silence       Maximum time of silence allowed (optional)
     *
     * @throws ChannelDownException
     * @return RecordResult
     */
    public function record($file, $format, $escapeDigits, $maxRecordTime = -1, $silence = false);

    /**
     * Tries to dial the given channel.
     *
     * @param string   $channel What to dial.
     * @param string[] $options Dial app options
     *
     * @throws ChannelDownException
     * @return DialResult
     */
    public function dial($channel, array $options = array());

    /**
     * Sends a fax.
     *
     * @param string $tiffFile Absolute path to a .tiff file.
     *
     * @return FaxResult
     */
    public function faxSend($tiffFile);

    /**
     * Receives a fax.
     *
     * @param string $tiffFile Absolute path to a .tiff file.
     *
     * @return FaxResult
     */
    public function faxReceive($tiffFile);

    /**
     * Indicates progress of a call, starting early audio.
     *
     * @return ExecResult
     */
    public function indicateProgress();
    /**
     * Indicates busy and waits for hangup. Does not play a busy tone.
     *
     * @param integer $timeout Time in seconds to wait for hangup
     *
     * @return ExecResult
     */
    public function indicateBusy($timeout);
    /**
     * Indicates congestion and waits for hangup. Does not play a busy tone.
     *
     * @param integer $timeout Time in seconds to wait for hangup
     *
     * @return ExecResult
     */
    public function indicateCongestion($timeout);
    /**
     * Plays a tone defined in indications.conf.
     *
     * @param string $tone Tone to play
     *
     * @return ExecResult
     */
    public function playTone($tone);
    /**
     * Plays a customized frequency tone.
     *
     * @param string[] $frequencies Frequencies for the tone: 425/50,0/50 or
     * !950/330,!1400/330,!1800/330,0 etc.
     *
     * @return ExecResult
     */
    public function playCustomTones(array $frequencies);
    /**
     * Stop playing current played tones.
     *
     * @return ExecResult
     */
    public function stopPlayingTones();

    /**
     * Plays "Dial" tone, defined in indications.conf
     *
     * @return ExecResult
     */
    public function playDialTone();
    /**
     * Plays "Busy" tone, defined in indications.conf
     *
     * @return ExecResult
     */
    public function playBusyTone();

    /**
     * Plays "Congestion" tone, defined in indications.conf
     *
     * @return ExecResult
     */
    public function playCongestionTone();

    /**
     * Convenient method to create a node.
     *
     * @param string $name
     *
     * @return Node
     */
    public function createNode($name);

    /**
     * Adds a SIP header to the first invite message in a dial command.
     *
     * @param string $name
     * @param string $value
     *
     * @return ExecResult
     */
    public function sipHeaderAdd($name, $value);

    /**
     * Removes a header previously added with sipHeaderAdd.
     *
     * @param string $name
     *
     * @return ExecResult
     */
    public function sipHeaderRemove($name);

    /**
     * Creates a new node controller.
     *
     * @param string $name
     *
     * @return NodeController
     */
    public function createNodeController($name);

    /**
     * Runs the AMD() application. For a complete list of options see:
     * https://wiki.asterisk.org/wiki/display/AST/Application_AMD
     *
     * @param string[] $options
     *
     * @return AmdResult 
     */
    public function amd($options);
}
