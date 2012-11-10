<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Application;

use PAGI\ClientInterface;

/**
 * Parent class for all Application.
 */
abstract Application
{
    /**
     * AGI Client.
     *
     * @var ClientInterface
     */
    private $client;

    /**
     * Called to initialize the application
     */
    abstract public function init();

    /**
     * Called when PHPvm is shutting down.
     */
    abstract public function shutdown();

    /**
     * Called to run the application, after calling init().
     */
    abstract public function run();

    /**
     * Your error handler. Be careful when implementing this one.
     *
     * @param integer $type    PHP Error type constant
     * @param string  $message Human readable error message string
     * @param string  $file    File that triggered the error
     * @param integer $line    Line that triggered the error
     *
     * @return Boolean
     */
    abstract public function errorHandler($type, $message, $file, $line);

    /**
     * Your signal handler. Be careful when implementing this one.
     *
     * @param integer $signal Signal catched
     */
    abstract public function signalHandler($signal);

    /**
     * Returns agi client.
     *
     * @return ClientInterface
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * Constructor. Will call set_error_handler() and pcntl_signal() to setup
     * your errorHandler() and signalHandler(). Also will call
     * register_shutdown_function() to register your shutdown() function.
     *
     * @param ClientInterface $client AGI client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        register_shutdown_function(array($this, 'shutdown'));

        $signalHandler = array($this, 'signalHandler');

        pcntl_signal(SIGINT,  $signalHandler);
        pcntl_signal(SIGQUIT, $signalHandler);
        pcntl_signal(SIGTERM, $signalHandler);
        pcntl_signal(SIGHUP,  $signalHandler);
        pcntl_signal(SIGUSR1, $signalHandler);
        pcntl_signal(SIGUSR2, $signalHandler);
        pcntl_signal(SIGCHLD, $signalHandler);
        pcntl_signal(SIGALRM, $signalHandler);

        set_error_handler(array($this, 'errorHandler'));
    }
}
