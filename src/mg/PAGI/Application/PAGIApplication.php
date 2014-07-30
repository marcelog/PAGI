<?php
/**
 * Parent class for all PAGIApplications.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Application
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/PAGI/
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
namespace PAGI\Application;

use PAGI\Client\IClient;
use PAGI\Client\Impl\ClientImpl;

/**
 * Parent class for all PAGIApplications.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Application
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
abstract class PAGIApplication
{
    /**
     * log4php logger or our own dummy.
     * @var Logger
     */
    protected $logger;

    /**
     * AGI Client.
     * @var IClient
     */
    private $_agiClient;

    /**
     * Called to initialize the application
     *
     * @return void
     */
    public abstract function init();

    /**
     * Called when PHPvm is shutting down.
     *
     * @return void
     */
    public abstract function shutdown();

    /**
     * Called to run the application, after calling init().
     *
     * @return void
     */
    public abstract function run();

    /**
     * Your error handler. Be careful when implementing this one.
     *
     * @param integer $type    PHP Error type constant.
     * @param string  $message Human readable error message string.
     * @param string  $file    File that triggered the error.
     * @param integer $line    Line that triggered the error.
     *
     * @return boolean
     */
    public abstract function errorHandler($type, $message, $file, $line);

    /**
     * Your signal handler. Be careful when implementing this one.
     *
     * @param integer $signal Signal catched.
     *
     * @return void
     */
    public abstract function signalHandler($signal);

    /**
     * Returns AGI Client.
     *
     * @return IClient
     */
    protected function getAgi()
    {
        return $this->_agiClient;
    }

    /**
     * Constructor. Will call set_error_handler() and pcntl_signal() to setup
     * your errorHandler() and signalHandler(). Also will call
     * register_shutdown_function() to register your shutdown() function.
     *
     * @param array $properties Optional additional properties.
     *
     * @return void
     */
    public function __construct(array $properties = array())
    {
        if (isset($properties['log4php.properties'])) {
            \Logger::configure($properties['log4php.properties']);
        }
        $this->logger = \Logger::getLogger('Pagi.PAGIApplication');
        $this->_agiClient = $properties['pagiClient'];
        register_shutdown_function(array($this, 'shutdown'));
        $signalHandler = array($this, 'signalHandler');
        pcntl_signal(SIGINT, $signalHandler);
        pcntl_signal(SIGQUIT, $signalHandler);
        pcntl_signal(SIGTERM, $signalHandler);
        pcntl_signal(SIGHUP, $signalHandler);
        pcntl_signal(SIGUSR1, $signalHandler);
        pcntl_signal(SIGUSR2, $signalHandler);
        pcntl_signal(SIGCHLD, $signalHandler);
        pcntl_signal(SIGALRM, $signalHandler);
        set_error_handler(array($this, 'errorHandler'));
    }
}
