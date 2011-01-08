<?php

namespace PAGI\Client\Impl;

use PAGI\Client\ClientVariables;
use PAGI\Exception\PAGIException;
use PAGI\Exception\ChannelDownException;
use PAGI\Exception\InvalidCommandException;
use PAGI\Client\IClient;

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

    public function sayDigits($digits, $escapeDigits = '', &$interrupted = false, &$digit = false)
    {
        $cmd = 'SAY DIGITS ' . $digits . ' "' . $escapeDigits . '"';
        $result = $this->send($cmd, $interrupted, $digit);
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

    public function answer()
    {
        return $this->send('ANSWER');
    }

    public function log($msg)
    {
        $msg = str_replace("\r", '', $msg);
        $msg = explode("\n", $msg);
        foreach ($msg as $line) {
            $this->send('VERBOSE "' . str_replace('"', '\'', $line) . '" 1');
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