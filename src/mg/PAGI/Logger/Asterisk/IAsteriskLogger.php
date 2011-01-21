<?php
/**
 * Facade to access asterisk logger (see logger.conf in your asterisk
 * installation).
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Logger
 * @subpackage Asterisk
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
namespace PAGI\Logger\Asterisk;

/**
 * Facade to access asterisk logger (see logger.conf in your asterisk
 * installation).
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Logger
 * @subpackage Asterisk
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
interface IAsteriskLogger
{
    /**
     * Logs with priority ERROR.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function error($msg);

    /**
     * Logs with priority WARNING.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function warn($msg);

    /**
     * Logs with priority NOTICE.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function notice($msg);

    /**
     * Logs with priority DEBUG.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function debug($msg);

    /**
     * Logs with priority VERBOSE.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function verbose($msg);

    /**
     * Logs with priority DTMF.
     *
     * @param string $msg Message to log.
     *
     * @return void
     */
    public function dtmf($msg);
}
