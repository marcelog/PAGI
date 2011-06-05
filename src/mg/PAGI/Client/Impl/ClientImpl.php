<?php
/**
 * An AGI client implementation.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
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
namespace PAGI\Client\Impl;

use PAGI\Logger\Asterisk\Impl\AsteriskLoggerImpl;

use PAGI\Client\Result\Result;
use PAGI\Client\Result\FaxResult;
use PAGI\Client\Result\ExecResult;
use PAGI\Client\Result\DialResult;
use PAGI\Client\Result\DigitReadResult;
use PAGI\Client\Result\DataReadResult;
use PAGI\Client\Result\PlayResult;
use PAGI\Client\Result\RecordResult;
use PAGI\Client\ChannelStatus;

use PAGI\Exception\ExecuteCommandException;
use PAGI\Exception\DatabaseInvalidEntryException;
use PAGI\Exception\PAGIException;
use PAGI\Exception\ChannelDownException;
use PAGI\Exception\SoundFileException;
use PAGI\Exception\InvalidCommandException;
use PAGI\Client\IClient;
use PAGI\ChannelVariables\Impl\ChannelVariablesFacade;
use PAGI\CDR\Impl\CDRFacade;
use PAGI\CallerId\Impl\CallerIdFacade;

/**
 * An AGI client implementation.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
class ClientImpl implements IClient
{
    /**
     * Current instance.
     * @var ClientImpl
     */
    private static $_instance = false;

    /**
     * log4php logger or dummy.
     * @var Logger
     */
    private $_logger;

    /**
     * Initial channel variables given by asterisk at start.
     * @var string[]
     */
    private $_variables;

    /**
     * Initial arguments given by the user in the dialplan.
     * @var string[]
     */
    private $_arguments;

    /**
     * AGI input
     * @var stream
     */
    private $_input;

    /**
     * AGI output
     * @var stream
     */
    private $_output;

    /**
     * Sends a command to asterisk. Returns an array with:
     * [0] => AGI Result (3 digits)
     * [1] => Command result
     * [2] => Result data.
     *
     * @param string $text Command
     *
     * @throws ChannelDownException
     * @throws InvalidCommandException
     *
     * @return Result
     */
    protected function send($text)
    {
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug('Sending: ' . $text);
        }
        $text .= "\n";
        $len = strlen($text);
        $res = fwrite($this->_output, $text) === $len;
        if ($res != true) {
            return false;
        }
        do {
            $res = $this->read();
        } while(strlen($res) < 2);
        $result = new Result($res);
        switch($result->getCode())
        {
        case 200:
            return $result;
        case 511:
            throw new ChannelDownException($text . ' - ' . $result);
        case 510:
        case 520:
        default:
            throw new InvalidCommandException($text . ' - ' . $result);
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::faxSend()
     */
    public function faxSend($tiffFile)
    {
        $result = new FaxResult($this->exec('SendFax', array($tiffFile, 'a')));
        $result->setResult($this->getFullVariable('FAXSTATUS') === 'SUCCESS');
        $result->setBitrate($this->getFullVariable('FAXBITRATE'));
        $result->setResolution($this->getFullVariable('FAXRESOLUTION'));
        $result->setPages($this->getFullVariable('FAXPAGES'));
        $result->setError($this->getFullVariable('FAXERROR'));
        $result->setRemoteStationId($this->getFullVariable('REMOTESTATIONID'));
        $result->setLocalStationId($this->getFullVariable('LOCALSTATIONID'));
        $result->setLocalHeaderInfo($this->getFullVariable('LOCALHEADERINFO'));
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::faxReceive()
     */
    public function faxReceive($tiffFile)
    {
        $result = new FaxResult($this->exec('ReceiveFax', array($tiffFile)));
        $result->setResult($this->getFullVariable('FAXSTATUS') === 'SUCCESS');
        $result->setBitrate($this->getFullVariable('FAXBITRATE'));
        $result->setResolution($this->getFullVariable('FAXRESOLUTION'));
        $result->setPages($this->getFullVariable('FAXPAGES'));
        $result->setError($this->getFullVariable('FAXERROR'));
        $result->setRemoteStationId($this->getFullVariable('REMOTESTATIONID'));
        $result->setLocalStationId($this->getFullVariable('LOCALSTATIONID'));
        $result->setLocalHeaderInfo($this->getFullVariable('LOCALHEADERINFO'));
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::dial()
     */
    public function dial($channel, array $options = array())
    {
        $start = time();
        array_unshift($options, $channel);
        $result = new DialResult($this->exec('Dial', $options));
        $end = time();
        $result->setPeerName($this->getFullVariable('DIALEDPEERNAME'));
        $result->setPeerNumber($this->getFullVariable('DIALEDPEERNUMBER'));
        $result->setDialedTime($end - $start);
        $result->setAnsweredTime($this->getFullVariable('ANSWEREDTIME'));
        $result->setDialStatus($this->getFullVariable('DIALSTATUS'));
        $result->setDynamicFeatures($this->getFullVariable('DYNAMIC_FEATURES'));
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::exec()
     */
    public function exec($application, array $options = array())
    {
        $cmd = implode(
        	' ', array(
        		'EXEC', '"' . $application . '"',
        		'"' . implode(',', $options) . '"'
            )
        );
        return new ExecResult($this->send($cmd));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setAutoHangup()
     */
    public function setAutoHangup($time)
    {
        $this->send(implode(' ', array('SET', 'AUTOHANGUP', $time)));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::channelStatus()
     */
    public function channelStatus($channel = false)
    {
        $cmd = implode(' ', array('CHANNEL', 'STATUS'));
        if ($channel !== false) {
            $cmd .= ' "' . $channel . '"';
        }
        $result = $this->send($cmd);
        return intval($result->getResult());
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::streamFile()
     */
    public function streamFile($file, $escapeDigits = '')
    {
        $cmd = implode(
        	' ',
        	array(
        		'STREAM', 'FILE', '"' . $file . '"', '"' . $escapeDigits . '"'
        	)
        );
        return new PlayResult(new DigitReadResult($this->send($cmd)));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::record()
     */
    public function record($file, $format, $escapeDigits, $maxRecordTime = -1, $silence = false)
    {
        $cmd = implode(
        	' ',
        	array(
        		'RECORD', 'FILE',
        		'"' . $file . '"', '"' . $format . '"',
        		'"' . $escapeDigits . '"', '"' . $maxRecordTime . '"'
        	)
        );
        if ($silence !== false) {
            $cmd .= ' "s=' . $silence . '"';
        }
        return new RecordResult($this->send($cmd));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setPriority()
     */
    public function setPriority($priority)
    {
        $cmd = implode(' ', array('SET', 'PRIORITY', '"' . $priority . '"'));
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setExtension()
     */
    public function setExtension($extension)
    {
        $cmd = implode(' ', array('SET', 'EXTENSION', '"' . $extension . '"'));
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setContext()
     */
    public function setContext($context)
    {
        $cmd = implode(' ', array('SET', 'CONTEXT', '"' . $context . '"'));
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setCallerId()
     */
    public function setCallerId($name, $number)
    {
        $clid = '\\"' . $name . '\\"<' . $number . '>';
        $cmd = implode(' ', array('SET', 'CALLERID', '"' . $clid . '"'));
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setMusic()
     */
    public function setMusic($enable, $class = false)
    {
        $cmd = implode(' ', array('SET', 'MUSIC', $enable ? 'on' : 'off'));
        if ($class !== false) {
            $cmd .= ' "' . $class . '"';
        }
        $this->send($cmd);
    }
    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getData()
     */
    public function getData($file, $maxTime, $maxDigits)
    {
        $timeout = false;
        $cmd = implode(
        	' ',
        	array(
        		'GET', 'DATA',
        		'"' . $file . '"',
        	    '"' . $maxTime . '"',
        	    '"' . $maxDigits . '"'
        	)
        );
        return new PlayResult(new DataReadResult($this->send($cmd)));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getOption()
     */
    public function getOption($file, $escapeDigits, $maxTime)
    {
        return $this->_playAndRead(implode(' ', array(
       		'GET', 'OPTION',
       		'"' . $file . '"', '"' . $escapeDigits . '"',
       	    '"' . $maxTime . '"'
        )));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayTime()
     */
    public function sayTime($time, $escapeDigits = '')
    {
        return $this->_playAndRead(implode(' ', array(
        	'SAY', 'TIME', '"' . $time . '"','"' . $escapeDigits . '"'
        )));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayDate()
     */
    public function sayDate($time, $escapeDigits = '')
    {
        return $this->_playAndRead(implode(' ', array(
        	'SAY', 'DATE', '"' . $time . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayDateTime()
     */
    public function sayDateTime($time, $format, $escapeDigits = '')
    {
        return $this->_playAndRead(implode(' ', array(
        	'SAY', 'DATETIME', '"' . $time . '"', '"' . $escapeDigits . '"', '"' . $format . '"'
        )));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayDigits()
     */
    public function sayDigits($digits, $escapeDigits = '')
    {
        return $this->_playAndRead(implode(' ', array(
        	'SAY', 'DIGITS', '"' . $digits . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayNumber()
     */
    public function sayNumber($digits, $escapeDigits = '')
    {
        return $this->_playAndRead(implode(' ', array(
        	'SAY', 'NUMBER', '"' . $digits . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayAlpha()
     */
    public function sayAlpha($what, $escapeDigits = '')
    {
        return $this->_playAndRead(implode(' ', array(
        	'SAY', 'ALPHA', '"' . $what . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayPhonetic()
     */
    public function sayPhonetic($what, $escapeDigits = '')
    {
        return $this->_playAndRead(implode(' ', array(
       		'SAY', 'PHONETIC', '"' . $what . '"', '"' . $escapeDigits . '"'
        )));
    }

    private function _playAndRead($cmd)
    {
        return new PlayResult(new DigitReadResult($this->send($cmd)));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::waitDigit()
     */
    public function waitDigit($timeout)
    {
        $cmd = implode(' ', array('WAIT', 'FOR', 'DIGIT', '"' . $timeout . '"'));
        return new DigitReadResult($this->send($cmd));
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::answer()
     */
    public function answer()
    {
        $result = $this->send('ANSWER');
        if ($result->isResult(-1)) {
            throw new ChannelDownException('Answer failed');
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::hangup()
     */
    public function hangup($channel = false)
    {
        $cmd = 'HANGUP';
        if ($channel !== false) {
            $cmd .= ' "' . $channel . '"';
        }
        $result = $this->send($cmd);
        if ($result->isResult(-1)) {
            throw new ChannelDownException('Hangup failed');
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getVariable()
     */
    public function getVariable($name)
    {
        $cmd = implode(' ', array('GET', 'VARIABLE', '"' . $name . '"'));
        $result = $this->send($cmd);
        if ($result->isResult(0)) {
            return false;
        }
        return substr($result->getData(), 1, -1);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getFullVariable()
     */
    public function getFullVariable($name, $channel = false)
    {
        $cmd = implode(
        	' ', array('GET', 'FULL', 'VARIABLE', '"${' . $name . '}"')
        );
        if ($channel !== false) {
            $cmd .= ' "' . $channel . '"';
        }
        $result = $this->send($cmd);
        if ($result->isResult(0)) {
            return false;
        }
        return substr($result->getData(), 1, -1);
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setVariable()
     */
    public function setVariable($name, $value)
    {
        $this->send(
            implode(
        		' ',
        	    array(
        			'SET', 'VARIABLE',
        	    	'"' . $name . '"',
        	    	'"' . str_replace('"', '\\"', $value) . '"'
        	    )
            )
        );
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::log()
     */
    public function log($msg, $priority = 'NOTICE')
    {
        $msg = str_replace("\r", '', $msg);
        $msg = explode("\n", $msg);
        foreach ($msg as $line) {
            $this->exec(
            	'LOG', array($priority, str_replace('"', '\\"', $line))
            );
        }

    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::log()
     */
    public function consoleLog($msg, $level = 1)
    {
        $msg = str_replace("\r", '', $msg);
        $msg = explode("\n", $msg);
        foreach ($msg as $line) {
            if (strlen($line) < 1) {
                continue;
            }
            $this->send(
            	'VERBOSE "' . str_replace('"', '\\"', $line) . '" ' . $level
            );
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getAsteriskLogger()
     */
    public function getAsteriskLogger()
    {
        return AsteriskLoggerImpl::getLogger($this);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::databaseDel()
     */
    public function databaseDel($family, $key)
    {
        $cmd = implode(
        	' ',
        	array(
        		'DATABASE', 'DELTREE', '"' . $family. '"', '"' . $key . '"'
        	)
        );
        $result = $this->send($cmd);
        if ($result->isResult(0)) {
            throw new DatabaseInvalidEntryException('Invalid family or key.');
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::databaseDeltree()
     */
    public function databaseDeltree($family, $key = false)
    {
        $cmd = implode(' ', array('DATABASE', 'DELTREE', '"' . $family . '"'));
        if ($key !== false) {
            $cmd .= ' "' . $key . '"';
        }
        $result = $this->send($cmd);
        if ($result->isResult(0)) {
            throw new DatabaseInvalidEntryException('Invalid family or key.');
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::databaseGet()
     */
    public function databaseGet($family, $key)
    {
        $cmd = implode(
        	' ', array('DATABASE', 'GET', '"' . $family. '"', '"' . $key . '"')
        );
        $result = $this->send($cmd);
        if ($result->isResult(0)) {
            throw new DatabaseInvalidEntryException('Invalid family or key.');
        }
        return substr($result->getData(), 1, -1);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::databasePut()
     */
    public function databasePut($family, $key, $value)
    {
        $cmd = implode(
        	' ',
        	array(
        		'DATABASE', 'PUT',
        	    '"' . $family . '"',
        	    '"' . $key . '"',
        	    '"' . $value . '"',
        	)
        );
        $result = $this->send($cmd);
        if ($result->isResult(0)) {
            throw new DatabaseInvalidEntryException('Invalid family or key.');
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sendText()
     */
    public function sendText($text)
    {
        $cmd = implode(' ', array('SEND', 'TEXT', '"' . $text . '"'));
        $result = $this->send($cmd);
        if ($result->isResult(-1)) {
            throw new PAGIException('Command failed');
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sendImage()
     */
    public function sendImage($filename)
    {
        $cmd = implode(' ', array('SEND', 'IMAGE', '"' . $filename . '"'));
        $result = $this->send($cmd);
        if ($result->isResult(-1)) {
            throw new PAGIException('Command failed');
        }
    }
    /**
     * Opens connection to agi. Will also read initial channel variables given
     * by asterisk when launching the agi.
     *
     * @return void
     */
    protected function open()
    {
        $this->_input = fopen('php://stdin', 'r');
        $this->_output = fopen('php://stdout', 'w');
        $this->_variables = array();
        $this->_arguments = $this->_variables; // Just reusing an empty array.
        while(true) {
            $line = $this->read($this->_input);
            if (strlen($line) < 1) {
                break;
            }
            $variableName = explode(':', substr($line, 4));
            $key = trim($variableName[0]);
            unset($variableName[0]);
            $value = trim(implode('', $variableName));
            if (strncmp($key, 'arg_', 4) === 0) {
                $this->_arguments[substr($key, 4)] = $value;
            } else {
                $this->_variables[$key] = $value;
            }
        }
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug(print_r($this->_variables, true));
        }
    }

    /**
     * Closes the connection to agi.
     *
     * @return void
     */
    protected function close()
    {
        if ($this->_input !== false) {
            fclose($this->_input);
        }
        if ($this->_output !== false) {
            fclose($this->_output);
        }
    }

    /**
     * Reads input from asterisk.
     *
     * @throws PAGIException
     *
     * @return string
     */
    protected function read()
    {
        $line = fgets($this->_input);
        if ($line === false) {
            throw new PAGIException('Could not read from AGI');
        }
        $line = substr($line, 0, -1);
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug('Read: ' . $line);
        }
        return $line;
    }

    /**
     * Returns a client instance for this call.
     *
     * @param array $options Optional properties.
     *
     * @return ClientImpl
     */
    public static function getInstance(array $options = array())
    {
        if (self::$_instance === false) {
            $ret = new ClientImpl($options);
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getChannelVariables()
     */
    public function getChannelVariables()
    {
        return ChannelVariablesFacade::getInstance(
            $this->_variables, $this->_arguments
        );
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getCDR()
     */
    public function getCDR()
    {
        return CDRFacade::getInstance($this);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getCallerId()
     */
    public function getCallerId()
    {
        return CallerIdFacade::getInstance($this);
    }

    /**
     * Constructor.
     *
     * @param array $options Optional properties.
     *
     * @return void
     */
    protected function __construct(array $options)
    {
        $this->_variables = false;
        $this->_input = false;
        $this->_output = false;
        if (isset($options['log4php.properties'])) {
            \Logger::configure($options['log4php.properties']);
        }
        $this->_logger = \Logger::getLogger('Pagi.ClientImpl');
        $this->open();
    }
}