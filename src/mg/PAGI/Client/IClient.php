<?php
/**
 * AGI Client interface.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Exception
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\Client;

/**
 * AGI Client interface.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Exception
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
interface IClient
{
    /**
     * Returns an instance of ChannelVariables to access agi variables.
     *
     * @return IChannelVariables
     */
    public function getChannelVariables();

    /**
     * Returns a cdr facade.
     *
     * @return ICDR
     */
    public function getCDR();

    /**
     * Returns a caller id facade.
     *
     * @return ICallerID
     */
    public function getCallerID();

    /**
     * Logs to asterisk console.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function log($msg);
}
