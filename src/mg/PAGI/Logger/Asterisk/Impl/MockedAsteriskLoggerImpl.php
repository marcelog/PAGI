<?php
/**
 * This will log to client logger instead of asterisk.
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
 * This will log to client logger instead of asterisk.
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
class MockedAsteriskLoggerImpl implements IAsteriskLogger
{
    /**
     * Logger to use.
     * @var \Logger
     */
    private $logger = false;

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::error()
     */
    public function error($msg)
    {
        $this->logger->debug("ASTERISK ERROR: $msg");
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::warn()
     */
    public function warn($msg)
    {
        $this->logger->debug("ASTERISK WARNING: $msg");
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::notice()
     */
    public function notice($msg)
    {
        $this->logger->debug("ASTERISK NOTICE: $msg");
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::debug()
     */
    public function debug($msg)
    {
        $this->logger->debug("ASTERISK DEBUG: $msg");
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::verbose()
     */
    public function verbose($msg)
    {
        $this->logger->debug("ASTERISK VERBOSE: $msg");
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Logger\Asterisk.IAsteriskLogger::dtmf()
     */
    public function dtmf($msg)
    {
        $this->logger->debug("ASTERISK DTMF: $msg");
    }

    /**
     * Constructor.
     *
     * @param \Logger $logger
     *
     * @return void
     */
    public function __construct(\Logger $logger)
    {
        $this->logger = $logger;
    }
}
