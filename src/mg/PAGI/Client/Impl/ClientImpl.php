<?php

namespace PAGI\Client\Impl;
use PAGI\Exception\PAGIException;
use PAGI\Client\IClient;

class ClientImpl implements IClient
{
    private $_variables;
    private $_input;
    private $_output;
    private static $_instance = false;

    protected function getAGIVariable($key)
    {
        if (!isset($this->_variables[$key])) {
            return false;
        }
        return $this->_variables[$key];
    }

    public function getChannel()
    {
        return $this->getAGIVariable('channel');
    }

    public function getLanguage()
    {
        return $this->getAGIVariable('language');
    }

    public function getType()
    {
        return $this->getAGIVariable('type');
    }

    public function getUniqueId()
    {
        return $this->getAGIVariable('uniqueid');
    }

    public function getVersion()
    {
        return $this->getAGIVariable('version');
    }

    public function getCallerId()
    {
        return $this->getAGIVariable('callerid');
    }

    public function getCallerIdName()
    {
        return $this->getAGIVariable('calleridname');
    }

    public function getCallingPres()
    {
        return $this->getAGIVariable('calleridpres');
    }

    public function getCallingAni2()
    {
        return $this->getAGIVariable('callingani2');
    }

    public function getCallingTon()
    {
        return $this->getAGIVariable('callington');
    }

    public function getCallingTns()
    {
        return $this->getAGIVariable('callingtns');
    }

    public function getDNID()
    {
        return $this->getAGIVariable('dnid');
    }

    public function getContext()
    {
        return $this->getAGIVariable('context');
    }

    public function getRDNIS()
    {
        return $this->getAGIVariable('rdnis');
    }

    public function getRequest()
    {
        return $this->getAGIVariable('request');
    }

    public function getDNIS()
    {
        return $this->getAGIVariable('extension');
    }

    public function getThreadId()
    {
        return $this->getAGIVariable('threadid');
    }

    public function getAccountCode()
    {
        return $this->getAGIVariable('accountcode');
    }

    public function getEnhanced()
    {
        return $this->getAGIVariable('enhanced');
    }

    public function getPriority()
    {
        return $this->getAGIVariable('priority');
    }

    protected function send($text)
    {
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
        $ret = array('code' => $code, 'result' => $result, 'data' => $data);
        if ($response[0] != 200) {
            throw new PAGIException(
            	'Could not send command: ' . $text . ' - '
                . print_r($res, true)
            );
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
        while(true) {
            $line = $this->read($this->_input);
            if (strlen($line) < 1) {
                break;
            }
            $variableName = explode(':', substr($line, 4));
            $key = trim($variableName[0]);
            unset($variableName[0]);
            $value = trim(implode('', $variableName));
            $this->_variables[$key] = $value;
        }
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
        return substr($line, 0, -1);
    }

    public static function getInstance()
    {
        if (self::$_instance === false) {
            $ret = new ClientImpl();
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }

    protected function __construct()
    {
        $this->_variables = array();
        $this->_input = false;
        $this->_output = false;
        $this->open();
    }

}