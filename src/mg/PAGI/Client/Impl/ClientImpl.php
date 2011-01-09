<?php

namespace PAGI\Client\Impl;

use PAGI\Client\ClientVariables;
use PAGI\Exception\PAGIException;
use PAGI\Exception\ChannelDownException;
use PAGI\Exception\SoundFileException;
use PAGI\Exception\InvalidCommandException;
use PAGI\Client\IClient;
use PAGI\Client\CDR;

class ClientImpl implements IClient
{
    private $_logger;
    private $_variables;
    private $_input;
    private $_output;

    private static $_instance = false;


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
        $response = explode(' ', $res);
        $code = $response[0];
        switch($code)
        {
        case 200:
            break;
        case 511:
            throw new ChannelDownException($text . ' - ' . print_r($res, true));
        case 510:
        case 520:
        default:
            throw new InvalidCommandException($text . ' - ' . print_r($res, true));
        }
        $result = '';
        $data = '';

        $result = explode('=', $response[1]);
        if (isset($result[1])) {
            $result = $result[1];
        }

        if (isset($response[2])) {
            unset($response[0]);
            unset($response[1]);
            $data = implode(' ', $response);
        }
        return array('code' => $code, 'result' => $result, 'data' => $data);
    }

    public function channelStatus($channel = false)
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'CHANNEL', 'STATUS',
        		$channel ? '"' . $channel . '"' : ''
        	)
        );
        $result = $this->send($cmd);
        return intval($result['result']);
    }

    public function streamFile($file, $escapeDigits, &$digit = false)
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'STREAM', 'FILE',
        		'"' . $file . '"',
        	    '"' . $escapeDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == -1) {
            throw new ChannelDownException('StreamFile failed');
        }
        $data = explode('=', $result['data']);
        if ($data[1] == 0) {
            throw new SoundFileException('Invalid format?');
        }
        if ($result['result'] > 0) {
            $digit = chr($result['result']);
        }
    }

    public function getData($file, $maxTime, $maxDigits, &$timeout = false, &$digits = false)
    {
        $timeout = false;
        $digits = false;
        $cmd = implode(
        	' ',
        	array(
        		'GET', 'DATA',
        		'"' . $file . '"',
        	    '"' . $maxTime . '"',
        	    '"' . $maxDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == -1) {
            throw new ChannelDownException('GetData failed');
        }
        $timeout = (strpos($result['data'], '(timeout)') !== false);
        $digits = $result['result'];
    }

    public function sayDigits($digits, $escapeDigits = '', &$interrupted = false, &$digit = false)
    {
        $digit = false;
        $interrupted = false;
        $cmd = implode(
        	' ',
        	array(
        		'SAY', 'DIGITS',
        		'"' . $digits . '"',
        	    '"' . $escapeDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        switch($result['result'])
        {
        case -1:
            throw new ChannelDownException('SayDigits failed');
            break;
        case 0:
            break;
        default:
            $interrupted = true;
            $digit = chr($result['result']);
            break;
        }
    }

    public function sayNumber($digits, $escapeDigits = '', &$interrupted = false, &$digit = false)
    {
        $digit = false;
        $interrupted = false;
        $cmd = implode(
        	' ',
        	array(
        		'SAY', 'NUMBER',
        		'"' . $digits . '"',
        	    '"' . $escapeDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        switch($result['result'])
        {
        case -1:
            throw new ChannelDownException('SayNumber failed');
            break;
        case 0:
            break;
        default:
            $interrupted = true;
            $digit = chr($result['result']);
            break;
        }
    }

    public function answer()
    {
        $result = $this->send('ANSWER');
        if ($result['result'] == -1) {
            throw new ChannelDownException('Answer failed');
        }
    }

    public function hangup($channel = false)
    {
        $cmd = implode(
        	' ',
        	array(
        		'HANGUP',
        		$channel ? '"' . $channel . '"' : ''
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == -1) {
            throw new ChannelDownException('Hangup failed');
        }
    }

    public function getCDRVariable($name)
    {
        return $this->getFullVariable('CDR(' . $name . ')');
    }

    public function setCDRVariable($name, $value)
    {
        $this->setVariable('CDR(' . $name . ')', $value);
    }

    public function getVariable($name)
    {
        $cmd = implode(
        	' ',
        	array(
        		'GET', 'VARIABLE',
        	    '"' . $name . '"'
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == 0) {
            return false;
        }
        return substr($result['data'], 1, -1);
    }

    public function getFullVariable($name, $channel = false)
    {
        $cmd = implode(
        	' ',
        	array(
        		'GET', 'FULL', 'VARIABLE',
        	    '"${' . $name . '}"',
        		$channel ? '"' . $channel . '"' : ''
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == 0) {
            return false;
        }
        return substr($result['data'], 1, -1);
    }

    public function setVariable($name, $value)
    {
        $cmd = implode(
        	' ',
        	array(
        		'SET', 'VARIABLE',
        	    '"' . $name . '"',
        	    '"' . str_replace('"', '\\"', $value) . '"'
        	)
        );
        $result = $this->send($cmd);
    }

    public function getCDR()
    {
        return new CDR($this);
    }

    public function log($msg)
    {
        $msg = str_replace("\r", '', $msg);
        $msg = explode("\n", $msg);
        foreach ($msg as $line) {
            $this->send('VERBOSE "' . str_replace('"', '\\"', $line) . '" 1');
        }
        return true;
    }

    protected function open()
    {
        $this->_input = fopen('php://stdin', 'r');
        $this->_output = fopen('php://stdout', 'w');
        $variables = array();
        $arguments = $variables; // Just reusing an empty array.
        while(true) {
            $line = $this->read($this->_input);
            if (strlen($line) < 1) {
                break;
            }
            $variableName = explode(':', substr($line, 4));
            $key = trim($variableName[0]);
            unset($variableName[0]);
            if ($this->_logger->isDebugEnabled()) {
                $this->_logger->debug(print_r($variableName, true));
            }
            $value = trim(implode('', $variableName));
            if (strncmp($key, 'arg_', 4) === 0) {
                $arguments[] = $value;
            } else {
                $variables[$key] = $value;
            }
        }
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug(print_r($variables, true));
        }
        $this->_variables = new ClientVariables($variables, $arguments);
    }

    protected function close()
    {
        if ($this->_input !== false) {
            fclose($input);
        }
        if ($this->_output !== false) {
            fclose($output);
        }
    }

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

    public function getClientVariables()
    {
        return $this->_variables;
    }

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