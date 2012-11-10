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
 * ChannelVariables facade. Use this to access channel variables.
 */
interface ChannelVariablesInterface
{
    /**
     * Returns channel (agi_channel).
     *
     * @return string
     */
    public function getChannel();

    /**
     * Returns language (agi_language).
     *
     * @return string
     */
    public function getLanguage();

    /**
     * Returns channel type (agi_type).
     *
     * @return string
     */
    public function getType();

    /**
     * Returns channel uniqueid (agi_uniqueid).
     *
     * @return string
     */
    public function getUniqueId();

    /**
     * Returns asterisk version (agi_version).
     *
     * @return string
     */
    public function getVersion();

    /**
     * Returns caller id number (agi_callerid).
     *
     * @return string
     */
    public function getCallerId();

    /**
     * Returns caller id name (agi_calleridname).
     *
     * @return string
     */
    public function getCallerIdName();

    /**
     * Returns CallingPres (agi_callingpres).
     *
     * @return string
     */
    public function getCallingPres();

    /**
     * Returns CallingAni (agi_callingani2).
     *
     * @return string
     */
    public function getCallingAni2();

    /**
     * Returns CallingTon (agi_callington).
     *
     * @return string
     */
    public function getCallingTon();

    /**
     * Returns CallingTns (agi_callingtns).
     *
     * @return string
     */
    public function getCallingTns();

    /**
     * Returns DNID (agi_dnid).
     *
     * @return string
     */
    public function getDNID();

    /**
     * Returns context (agi_context).
     *
     * @return string
     */
    public function getContext();

    /**
     * Returns RDNIS (agi_rdnis).
     *
     * @return string
     */
    public function getRDNIS();

    /**
     * Returns agi requested (agi_request).
     *
     * @return string
     */
    public function getRequest();

    /**
     * Returns extension dialed (dnis) (agi_extension).
     *
     * @return string
     */
    public function getDNIS();

    /**
     * Returns thread id (agi_threadid).
     *
     * @return string
     */
    public function getThreadId();

    /**
     * Returns account code (agi_accountcode).
     *
     * @return string
     */
    public function getAccountCode();

    /**
     * Returns if using enhanced (agi_enhanced).
     *
     * @return string
     */
    public function getEnhanced();

    /**
     * Returns context priority (agi_priority).
     *
     * @return string
     */
    public function getPriority();

    /**
     * Returns total number of agi arguments.
     *
     * @return integer
     */
    public function getTotalArguments();

    /**
     * Returns the given agi argument. (agi_arg_N).
     *
     * @param integer $index Argument number, starting with 0
     *
     * @return string
     */
    public function getArgument($index);

    /**
     * Returns all arguments as an array.
     *
     * @return array
     */
    public function getArguments();

    /**
     * Returns the config directory for this running version of asterisk.
     * Uses environment variable AST_CONFIG_DIR.
     *
     * @return string
     */
    public function getDirectoryConfig();

    /**
     * Returns the config file for this running version of asterisk.
     * Uses environment variable AST_CONFIG_FILE.
     *
     * @return string
     */
    public function getConfigFile();

    /**
     * Returns the modules directory for this running version of asterisk.
     * Uses environment variable AST_MODULE_DIR.
     *
     * @return string
     */
    public function getDirectoryModules();

    /**
     * Returns the spool directory for this running version of asterisk.
     * Uses environment variable AST_SPOOL_DIR.
     *
     * @return string
     */
    public function getDirectorySpool();

    /**
     * Returns the monitor directory for this running version of asterisk.
     * Uses environment variable AST_MONITOR_DIR.
     *
     * @return string
     */
    public function getDirectoryMonitor();

    /**
     * Returns the var directory for this running version of asterisk.
     * Uses environment variable AST_VAR_DIR.
     *
     * @return string
     */
    public function getDirectoryVar();

    /**
     * Returns the data directory for this running version of asterisk.
     * Uses environment variable AST_DATA_DIR.
     *
     * @return string
     */
    public function getDirectoryData();

    /**
     * Returns the log directory for this running version of asterisk.
     * Uses environment variable AST_LOG_DIR.
     *
     * @return string
     */
    public function getDirectoryLog();

    /**
     * Returns the agi directory for this running version of asterisk.
     * Uses environment variable AST_AGI_DIR.
     *
     * @return string
     */
    public function getDirectoryAgi();

    /**
     * Returns the key directory for this running version of asterisk.
     * Uses environment variable AST_KEY_DIR.
     *
     * @return string
     */
    public function getDirectoryKey();

    /**
     * Returns the run directory for this running version of asterisk.
     * Uses environment variable AST_RUN_DIR.
     *
     * @return string
     */
    public function getDirectoryRun();
}
