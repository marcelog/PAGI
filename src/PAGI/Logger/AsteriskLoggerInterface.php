<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Logger;

/**
 * Facade to access asterisk logger (see logger.conf in your asterisk
 * installation).
 */
interface AsteriskLoggerInterface
{
    /**
     * Logs with priority ERROR.
     *
     * @param string $message Message to log
     */
    public function error($message);

    /**
     * Logs with priority WARNING.
     *
     * @param string $message Message to log
     */
    public function warn($message);

    /**
     * Logs with priority NOTICE.
     *
     * @param string $message Message to log
     */
    public function notice($message);

    /**
     * Logs with priority DEBUG.
     *
     * @param string $message Message to log
     */
    public function debug($message);

    /**
     * Logs with priority VERBOSE.
     *
     * @param string $message Message to log
     */
    public function verbose($message);

    /**
     * Logs with priority DTMF.
     *
     * @param string $message Message to log
     */
    public function dtmf($message);
}
