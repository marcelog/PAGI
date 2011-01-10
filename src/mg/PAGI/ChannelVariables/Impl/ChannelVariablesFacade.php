<?php
/**
 * ChannelVariables facade implementation.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    ChannelVariables
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
namespace PAGI\ChannelVariables\Impl;

use PAGI\ChannelVariables\IChannelVariables;

/**
 * ChannelVariables facade implementation.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    ChannelVariables
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
class ChannelVariablesFacade implements IChannelVariables
{
    /**
     * Channel variables given by asterisk.
     * @var string[]
     */
    private $_variables;

    /**
     * AGI Arguments (agi_arg_N).
     * @var string[]
     */
    private $_arguments;

    /**
     * Current instance.
     * @var ChannelVariablesFacade
     */
    private static $_instance = false;

    /**
     * Returns the given variable. Returns false if not set.
     *
     * @param string $key Variable to get.
     *
     * @return string
     */
    protected function getAGIVariable($key)
    {
        if (!isset($this->_variables[$key])) {
            return false;
        }
        return $this->_variables[$key];
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getChannel()
     */
    public function getChannel()
    {
        return $this->getAGIVariable('channel');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getLanguage()
     */
    public function getLanguage()
    {
        return $this->getAGIVariable('language');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getType()
     */
    public function getType()
    {
        return $this->getAGIVariable('type');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getUniqueId()
     */
    public function getUniqueId()
    {
        return $this->getAGIVariable('uniqueid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getVersion()
     */
    public function getVersion()
    {
        return $this->getAGIVariable('version');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getCallerId()
     */
    public function getCallerId()
    {
        return $this->getAGIVariable('callerid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getCallerIdName()
     */
    public function getCallerIdName()
    {
        return $this->getAGIVariable('calleridname');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getCallingPres()
     */
    public function getCallingPres()
    {
        return $this->getAGIVariable('calleridpres');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getCallingAni2()
     */
    public function getCallingAni2()
    {
        return $this->getAGIVariable('callingani2');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getCallingTon()
     */
    public function getCallingTon()
    {
        return $this->getAGIVariable('callington');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getCallingTns()
     */
    public function getCallingTns()
    {
        return $this->getAGIVariable('callingtns');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getDNID()
     */
    public function getDNID()
    {
        return $this->getAGIVariable('dnid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getContext()
     */
    public function getContext()
    {
        return $this->getAGIVariable('context');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getRDNIS()
     */
    public function getRDNIS()
    {
        return $this->getAGIVariable('rdnis');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getRequest()
     */
    public function getRequest()
    {
        return $this->getAGIVariable('request');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getDNIS()
     */
    public function getDNIS()
    {
        return $this->getAGIVariable('extension');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getThreadId()
     */
    public function getThreadId()
    {
        return $this->getAGIVariable('threadid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getAccountCode()
     */
    public function getAccountCode()
    {
        return $this->getAGIVariable('accountcode');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getEnhanced()
     */
    public function getEnhanced()
    {
        return $this->getAGIVariable('enhanced');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getPriority()
     */
    public function getPriority()
    {
        return $this->getAGIVariable('priority');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getTotalArguments()
     */
    public function getTotalArguments()
    {
        return count($this->_arguments);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\ChannelVariables.IChannelVariables::getArgument()
     */
    public function getArgument($index)
    {
        if (isset($this->_arguments[$index])) {
            return $this->_arguments[$index];
        }
        return false;
    }

    /**
     * Returns an instance for this facade implementation.
     *
     * @param string[] $variables Initial channel variables given by asterisk.
     * @param string[] $arguments AGI arguments given by asterisk (agi_arg_N).
     *
     * @return ChannelVariablesFacade
     */
    public static function getInstance(
        array $variables = array(), array $arguments = array()
    ) {
        if (self::$_instance === false) {
            $ret = new ChannelVariablesFacade($variables, $arguments);
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }

    /**
     * Constructor.
     *
     * @param string[] $variables Initial channel variables given by asterisk.
     * @param string[] $arguments AGI arguments given by asterisk (agi_arg_N).
     *
     * @return void
     */
    protected function __construct(array $variables, array $arguments)
    {
        $this->_variables = $variables;
        $this->_arguments = $arguments;
    }
}