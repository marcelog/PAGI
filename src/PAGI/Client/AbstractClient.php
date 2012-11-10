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

use PAGI\Logger\AsteriskLogger;

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

use PAGI\Exception\DatabaseInvalidEntryException;
use PAGI\Exception\PAGIException;
use PAGI\Exception\ChannelDownException;
use PAGI\Exception\InvalidCommandException;

use PAGI\Client\ClientInterface;
use PAGI\ChannelVariables\ChannelVariablesFacade;
use PAGI\CDR\CDRFacade;
use PAGI\CallerId\CallerIdFacade;
use PAGI\Node\Node;
use PAGI\Node\NodeController;

/**
 * An abstract AGI client.
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     * Initial channel variables given by asterisk at start.
     *
     * @var array
     */
    protected $variables = array();

    /**
     * Initial arguments given by the user in the dialplan.
     *
     * @var array
     */
    protected $arguments = array();

    protected $cdr;
    protected $channelVariables;
    protected $callerid;

    /**
     * Sends a command to asterisk. Returns an array with:
     * [0] => AGI Result (3 digits)
     * [1] => Command result
     * [2] => Result data.
     *
     * @param string $text Command
     *
     * @return Result
     *
     * @throws ChannelDownException
     * @throws InvalidCommandException
     */
    abstract protected function send($text);

    /**
     * Opens connection to agi. Will also read initial channel variables given
     * by asterisk when launching the agi.
     */
    abstract protected function open();

    /**
     * Closes the connection to agi.
     */
    abstract protected function close();

    /**
     * Returns a result object given a string (the agi result after executing
     * a command).
     *
     * @param mix $text
     *
     * @return Result
     *
     * @throws ChannelDownException
     * @throws InvalidCommandException
     */
    protected function getResultFromResultString($text)
    {
        $result = new Result($text);
        switch ($result->getCode()) {
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
     * {@inheritdoc}
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
                $args[] = null;
            }
        }
        $result = new AmdResult($this->exec('AMD', $args));
        $result->setStatus($this->getFullVariable('AMDSTATUS'));
        $result->setCause($this->getFullVariable('AMDCAUSE'));

        return $result;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function setAutoHangup($time)
    {
        $this->send(implode(' ', array('SET', 'AUTOHANGUP', $time)));
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function streamFile($file, $escapeDigits = null)
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function setPriority($priority)
    {
        $cmd = implode(' ', array('SET', 'PRIORITY', '"' . $priority . '"'));
        $this->send($cmd);
    }

    /**
     * {@inheritdoc}
     */
    public function setExtension($extension)
    {
        $cmd = implode(' ', array('SET', 'EXTENSION', '"' . $extension . '"'));
        $this->send($cmd);
    }

    /**
     * {@inheritdoc}
     */
    public function setContext($context)
    {
        $cmd = implode(' ', array('SET', 'CONTEXT', '"' . $context . '"'));
        $this->send($cmd);
    }

    /**
     * {@inheritdoc}
     */
    public function setCallerId($name, $number)
    {
        $callerid = '\\"' . $name . '\\"<' . $number . '>';
        $cmd = implode(' ', array('SET', 'CALLERID', '"' . $callerid . '"'));
        $this->send($cmd);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function sayTime($time, $escapeDigits = null)
    {
        return $this->_playAndRead(implode(' ', array(
            'SAY', 'TIME', '"' . $time . '"','"' . $escapeDigits . '"'
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function sayDate($time, $escapeDigits = null)
    {
        return $this->_playAndRead(implode(' ', array(
            'SAY', 'DATE', '"' . $time . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function sayDateTime($time, $format, $escapeDigits = null)
    {
        return $this->_playAndRead(implode(' ', array(
            'SAY', 'DATETIME', '"' . $time . '"', '"' . $escapeDigits . '"', '"' . $format . '"'
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function sayDigits($digits, $escapeDigits = null)
    {
        return $this->_playAndRead(implode(' ', array(
            'SAY', 'DIGITS', '"' . $digits . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function sayNumber($digits, $escapeDigits = null)
    {
        return $this->_playAndRead(implode(' ', array(
            'SAY', 'NUMBER', '"' . $digits . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function sayAlpha($what, $escapeDigits = null)
    {
        return $this->_playAndRead(implode(' ', array(
            'SAY', 'ALPHA', '"' . $what . '"', '"' . $escapeDigits . '"'
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function sayPhonetic($what, $escapeDigits = null)
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
     * {@inheritdoc}
     */
    public function waitDigit($timeout)
    {
        $cmd = implode(' ', array('WAIT', 'FOR', 'DIGIT', '"' . $timeout . '"'));

        return new DigitReadResult($this->send($cmd));
    }

    /**
     * {@inheritdoc}
     */
    public function answer()
    {
        $result = $this->send('ANSWER');
        if ($result->isResult(-1)) {
            throw new ChannelDownException('Answer failed');
        }
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function log($message, $priority = 'NOTICE')
    {
        $message = str_replace("\r", '', $message);
        $message = explode("\n", $message);
        foreach ($message as $line) {
            $this->exec(
                'LOG', array($priority, str_replace('"', '\\"', $line))
            );
        }

    }

    /**
     * {@inheritdoc}
     */
    public function consoleLog($message, $level = 1)
    {
        $message = str_replace("\r", '', $message);
        $message = explode("\n", $message);
        foreach ($message as $line) {
            if (strlen($line) < 1) {
                continue;
            }
            $this->send(
                'VERBOSE "' . str_replace('"', '\\"', $line) . '" ' . $level
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAsteriskLogger()
    {
        return AsteriskLogger::getInstance($this);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * @return Boolean
     */
    protected function isEndOfEnvironmentVariables($line)
    {
        return strlen($line) < 1;
    }

    /**
     * Will read and save an environment variable as either a variable or an argument.
     *
     * @param string $line
     */
    protected function readEnvironmentVariable($line)
    {
        $variableName = explode(':', substr($line, 4));
        $key = trim($variableName[0]);
        unset($variableName[0]);
        $value = trim(implode(null, $variableName));
        if (strncmp($key, 'arg_', 4) === 0) {
            $this->arguments[substr($key, 4)] = $value;
        } else {
            $this->variables[$key] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getChannelVariables()
    {
        if ($this->channelVariables === false) {
            $this->channelVariables = new ChannelVariablesFacade(
                $this->variables, $this->arguments
            );
        }

        return $this->channelVariables;
    }

    /**
     * {@inheritdoc}
     */
    public function getCDR()
    {
        if ($this->cdr === false) {
            $this->cdr = new CDRFacade($this);
        }

        return $this->cdr;
    }

    /**
     * {@inheritdoc}
     */
    public function getCallerId()
    {
        if ($this->callerid === false) {
            $this->callerid = new CallerIdFacade($this);
        }

        return $this->callerid;
    }

    /**
     * {@inheritdoc}
     */
    public function indicateProgress()
    {
        return $this->exec('Progress', array());
    }

    /**
     * {@inheritdoc}
     */
    public function indicateBusy($timeout)
    {
        return $this->exec('Busy', array($timeout));
    }

    /**
     * {@inheritdoc}
     */
    public function indicateCongestion($timeout)
    {
        return $this->exec('Congestion', array($timeout));
    }

    /**
     * {@inheritdoc}
     */
    public function playDialTone()
    {
        return $this->playTone('dial');
    }

    /**
     * {@inheritdoc}
     */
    public function playBusyTone()
    {
        return $this->playTone('Busy');
    }

    /**
     * {@inheritdoc}
     */
    public function playCongestionTone()
    {
        return $this->playTone('Congestion');
    }

    /**
     * {@inheritdoc}
     */
    public function playTone($tone)
    {
        return $this->exec('PlayTones', array($tone));
    }

    /**
     * {@inheritdoc}
     */
    public function playCustomTones(array $frequencies)
    {
        return $this->exec('PlayTones', $frequencies);
    }

    /**
     * {@inheritdoc}
     */
    public function stopPlayingTones()
    {
        return $this->exec('StopPlayTones', array());
    }

    /**
     * {@inheritdoc}
     */
    public function createNode($name)
    {
        $node = new Node();

        return $node->setName($name)->setClient($this);
    }

    /**
     * {@inheritdoc}
     */
    public function sipHeaderAdd($name, $value)
    {
        $this->exec('SipAddHeader', array("$name: $value"));
    }

    /**
     * {@inheritdoc}
     */
    public function sipHeaderRemove($name)
    {
        $result = $this->exec('SipRemoveHeader', array($name));

        return $result->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function createNodeController($name)
    {
        $controller = new NodeController();

        return $controller->setName($name)->setClient($this);
    }
}
