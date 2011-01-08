<?php
namespace PAGI\Client;

class ClientVariables
{
    private $_variables;

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

    public function getTotalArguments()
    {
        global $argc;
        return $argc;
    }

    public function getArgument($index)
    {
        global $argv;
        if (isset($argv[$index])) {
            return $argv[$index];
        }
        return false;
    }

    public function __construct(array $variables)
    {
        $this->_variables = $variables;
    }
}