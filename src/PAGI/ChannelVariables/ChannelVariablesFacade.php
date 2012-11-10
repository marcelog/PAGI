<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\ChannelVariables;

/**
 * ChannelVariables facade implementation.
 */
class ChannelVariablesFacade implements ChannelVariablesInterface
{
    /**
     * Channel variables given by asterisk.
     *
     * @var array
     */
    private $variables;

    /**
     * AGI Arguments (agi_arg_N).
     *
     * @var array
     */
    private $arguments;

    /**
     * Constructor.
     *
     * @param array $variables Initial channel variables given by asterisk
     * @param array $arguments AGI arguments given by asterisk (agi_arg_N)
     */
    public function __construct(array $variables = array(), array $arguments = array())
    {
        $this->variables = $variables;
        $this->arguments = $arguments;
    }

    /**
     * Returns the given variable. Returns false if not set.
     *
     * @param string $key Variable to get
     *
     * @return string
     */
    protected function getVariable($key)
    {
        if (!isset($this->variables[$key])) {
            return false;
        }

        return $this->variables[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getChannel()
    {
        return $this->getVariable('channel');
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage()
    {
        return $this->getVariable('language');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->getVariable('type');
    }

    /**
     * {@inheritdoc}
     */
    public function getUniqueId()
    {
        return $this->getVariable('uniqueid');
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->getVariable('version');
    }

    /**
     * {@inheritdoc}
     */
    public function getCallerId()
    {
        return $this->getVariable('callerid');
    }

    /**
     * {@inheritdoc}
     */
    public function getCallerIdName()
    {
        return $this->getVariable('calleridname');
    }

    /**
     * {@inheritdoc}
     */
    public function getCallingPres()
    {
        return $this->getVariable('callingpres');
    }

    /**
     * {@inheritdoc}
     */
    public function getCallingAni2()
    {
        return $this->getVariable('callingani2');
    }

    /**
     * {@inheritdoc}
     */
    public function getCallingTon()
    {
        return $this->getVariable('callington');
    }

    /**
     * {@inheritdoc}
     */
    public function getCallingTns()
    {
        return $this->getVariable('callingtns');
    }

    /**
     * {@inheritdoc}
     */
    public function getDNID()
    {
        return $this->getVariable('dnid');
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->getVariable('context');
    }

    /**
     * {@inheritdoc}
     */
    public function getRDNIS()
    {
        return $this->getVariable('rdnis');
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        return $this->getVariable('request');
    }

    /**
     * {@inheritdoc}
     */
    public function getDNIS()
    {
        return $this->getVariable('extension');
    }

    /**
     * {@inheritdoc}
     */
    public function getThreadId()
    {
        return $this->getVariable('threadid');
    }

    /**
     * {@inheritdoc}
     */
    public function getAccountCode()
    {
        return $this->getVariable('accountcode');
    }

    /**
     * {@inheritdoc}
     */
    public function getEnhanced()
    {
        return $this->getVariable('enhanced');
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->getVariable('priority');
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalArguments()
    {
        return count($this->arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function getArgument($index)
    {
        if (isset($this->arguments[$index])) {
            return $this->arguments[$index];
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryConfig()
    {
        return getenv('AST_CONFIG_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigFile()
    {
        return getenv('AST_CONFIG_FILE');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryModules()
    {
        return getenv('AST_MODULE_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectorySpool()
    {
        return getenv('AST_SPOOL_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryMonitor()
    {
        return getenv('AST_MONITOR_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryVar()
    {
        return getenv('AST_VAR_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryData()
    {
        return getenv('AST_DATA_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryLog()
    {
        return getenv('AST_LOG_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryAgi()
    {
        return getenv('AST_AGI_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryKey()
    {
        return getenv('AST_KEY_DIR');
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryRun()
    {
        return getenv('AST_RUN_DIR');
    }
}
