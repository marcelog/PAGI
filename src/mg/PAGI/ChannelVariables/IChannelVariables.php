<?php
/**
 * ChannelVariables facade. Use this to access channel variables.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  ChannelVariables
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\ChannelVariables;

/**
 * ChannelVariables facade. Use this to access channel variables.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  ChannelVariables
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
interface IChannelVariables
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
     * @param integer $index Argument number, starting with 0.
     *
     * @return string
     */
    public function getArgument($index);
}