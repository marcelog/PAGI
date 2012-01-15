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
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/PAGI/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
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
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
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
