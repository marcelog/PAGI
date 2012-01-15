<?php
/**
 * Facade to access asterisk logger (see logger.conf in your asterisk
 * installation).
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Logger
 * @subpackage Asterisk.Impl
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
namespace PAGI\Logger\Asterisk\Impl;

use PAGI\Client\IClient;
use PAGI\Logger\Asterisk\IAsteriskLogger;

/**
 * Facade to access asterisk logger (see logger.conf in your asterisk
 * installation).
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Logger
 * @subpackage Asterisk.Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class AsteriskLoggerImpl implements IAsteriskLogger
{
    /**
     * Holds instance of AGI Client.
     * @var IClient
     */
    private $_agi = false;

    /**
     * Holds identity to prepend.
     */
    private $_ident;

    /**
     * Holds current instance.
     * @var AsteriskLoggerImpl
     */
    private static $_instance = false;

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::error()
     */
    public function error($msg)
    {
        $this->_agi->log($msg, 'ERROR');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::warn()
     */
    public function warn($msg)
    {
        $this->_agi->log($msg, 'WARNING');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::notice()
     */
    public function notice($msg)
    {
        $this->_agi->log($msg, 'NOTICE');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::debug()
     */
    public function debug($msg)
    {
        $this->_agi->log($msg, 'DEBUG');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::verbose()
     */
    public function verbose($msg)
    {
        $this->_agi->log($msg, 'VERBOSE');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::dtmf()
     */
    public function dtmf($msg)
    {
        $this->_agi->log($msg, 'DTMF');
    }

    /**
     * Obtains an instance for this facade.
     *
     * @param IClient $agi Client AGI to use.
     *
     * @return void
     */
    public static function getLogger(IClient $agi)
    {
        if (self::$_instance === false) {
            $ret = new AsteriskLoggerImpl($agi);
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }

    /**
     * Constructor.
     *
     * @param IClient $agi AGI client.
     *
     * @return void
     */
    protected function __construct(IClient $agi)
    {
        $this->_agi = $agi;
        $this->_ident = '';
    }
}
