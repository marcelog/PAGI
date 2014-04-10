<?php
/**
 * An abstract AGI client.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
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

use PAGI\Logger\Asterisk\Impl\AsteriskLoggerImpl;

use PAGI\Client\Result\Result;
use PAGI\Client\Result\FaxResult;
use PAGI\Client\Result\ExecResult;
use PAGI\Client\Result\DialResult;
use PAGI\Client\Result\DigitReadResult;
use PAGI\Client\Result\DataReadResult;
use PAGI\Client\Result\PlayResult;
use PAGI\Client\Result\RecordResult;
use PAGI\Client\Result\AmdResult;
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
 * An abstract AGI client.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
abstract class AbstractClient implements IClient
{
    /**
     * log4php logger or dummy.
     * @var Logger
     */
    protected $_logger;

    /**
     * Initial channel variables given by asterisk at start.
     * @var string[]
     */
    protected $_variables = array();

    /**
     * Initial arguments given by the user in the dialplan.
     * @var string[]
     */
    protected $_arguments = array();

    protected $cdrInstance = false;
    protected $channelVariablesInstance = false;
    protected $clidInstance = false;

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
    protected abstract function send($text);

    /**
     * Opens connection to agi. Will also read initial channel variables given
     * by asterisk when launching the agi.
     *
     * @return void
     */
    protected abstract function open();

    /**
     * Closes the connection to agi.
     *
     * @return void
     */
    protected abstract function close();

    /**
     * Returns a result object given a string (the agi result after executing
     * a command).
     *
     * @param unknown_type $text
     * @throws ChannelDownException
     * @throws InvalidCommandException
     *
     * @return Result
     */
    protected function getResultFromResultString($text)
    {
        if($text == 'HANGUP') {
            throw new ChannelDownException(new Result('511 asterisk hangup'));
        }
        $result = new Result($text);
        switch($result->getCode())
        {
        case 200:
            return $result;
        case 511:
            throw new ChannelDownException($result);
        case 510:
        case 520:
        default:
            break;
        }
        throw new InvalidCommandException($result);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::amd()
     */
    public function amd($options = array())
    {
        $knownOptions = array(
            'initialSilence', 'greeting', 'afterGreetingSilence', 'totalAnalysisTime', 
            'miniumWordLength', 'betweenWordSilence', 'maximumNumberOfWords',
            'silenceThreshold', 'maximumWordLength'
        );
        $args = array();
        $total = count($knownOptions);
        for ($i = 0; $i < $total; $i++) {
            $key = $knownOptions[$i];
            if (isset($options[$key])) {
                $args[] = $options[$key];
            } else {
                $args[] = '';
            }
        }
        $result = new AmdResult($this->exec('AMD', $args));
        $result->setStatus($this->getFullVariable('AMDSTATUS'));
        $result->setCause($this->getFullVariable('AMDCAUSE'));
        return $result;
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
     * Returns true if the current line marks the end of the environment variables.
     *
     * @param string $line
     *
     * @return boolean
     */
    protected function isEndOfEnvironmentVariables($line)
    {
        return strlen($line) < 1;
    }

    /**
     * Will read and save an environment variable as either a variable or an argument.
     *
     * @param string $line
     *
     * @return void
     */
    protected function readEnvironmentVariable($line)
    {
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

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getChannelVariables()
     */
    public function getChannelVariables()
    {
        if ($this->channelVariablesInstance === false) {
            $this->channelVariablesInstance = new ChannelVariablesFacade(
                $this->_variables, $this->_arguments
            );
        }
        return $this->channelVariablesInstance;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getCDR()
     */
    public function getCDR()
    {
        if ($this->cdrInstance === false) {
            $this->cdrInstance = new CDRFacade($this);
        }
        return $this->cdrInstance;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getCallerId()
     */
    public function getCallerId()
    {
        if ($this->clidInstance === false) {
            $this->clidInstance = new CallerIdFacade($this);
        }
        return $this->clidInstance;
    }

    /**
     * (non-PHPdoc)
     * @see IClient::indicateProgress()
     */
    public function indicateProgress()
    {
        return $this->exec('Progress', array());
    }

    /**
     * (non-PHPdoc)
     * @see IClient::indicateBusy()
     */
    public function indicateBusy($timeout)
    {
        return $this->exec('Busy', array($timeout));
    }

    /**
     * (non-PHPdoc)
     * @see IClient::indicateCongestion()
     */
    public function indicateCongestion($timeout)
    {
        return $this->exec('Congestion', array($timeout));
    }
    /**
     * (non-PHPdoc)
     * @see IClient::playDialTone()
     */
    public function playDialTone()
    {
        return $this->playTone('dial');
    }

    /**
     * (non-PHPdoc)
     * @see IClient::playBusyTone()
     */
    public function playBusyTone()
    {
        return $this->playTone('Busy');
    }

    /**
     * (non-PHPdoc)
     * @see IClient::playCongestionTone()
     */
    public function playCongestionTone()
    {
        return $this->playTone('Congestion');
    }

    /**
     * (non-PHPdoc)
     * @see IClient::playTone()
     */
    public function playTone($tone)
    {
        return $this->exec('PlayTones', array($tone));
    }
    /**
     * (non-PHPdoc)
     * @see IClient::playCustomTones()
     */
    public function playCustomTones(array $frequencies)
    {
        return $this->exec('PlayTones', $frequencies);
    }
    /**
     * (non-PHPdoc)
     * @see IClient::stopPlayingTones()
     */
    public function stopPlayingTones()
    {
        return $this->exec('StopPlayTones', array());
    }

    /**
     * (non-PHPdoc)
     * @see IClient::createNode()
     */
    public function createNode($name)
    {
        $node = new \PAGI\Node\Node();
        return $node->setName($name)->setAgiClient($this);
    }

    /**
     * (non-PHPdoc)
     * @see IClient::sipHeaderAdd()
     */
    public function sipHeaderAdd($name, $value)
    {
        $this->exec('SipAddHeader', array("$name: $value"));
    }

    /**
     * (non-PHPdoc)
     * @see IClient::sipHeaderRemove()
     */
    public function sipHeaderRemove($name)
    {
        $result = $this->exec('SipRemoveHeader', array($name));
        return $result->getData();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::createNodeController()
     */
    public function createNodeController($name)
    {
        $controller = new \PAGI\Node\NodeController();
        return $controller->setName($name)->setAgiClient($this);
    }
}
