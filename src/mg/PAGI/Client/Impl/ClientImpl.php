<?php

namespace PAGI\Client\Impl;
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
        $result = fwrite($this->_output, $text) === $len;
        if ($result != true) {
            return false;
        }
        $result = $this->read();
    }

    public function log($msg)
    {
        return $this->send('VERBOSE "' . $msg . '" 1');
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
        return substr(fgets($this->_input), 0, -1);
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