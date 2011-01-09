<?php
namespace PAGI\Application;

use PAGI\Client\Impl\ClientImpl;
use PAGI\Call\Call;
use PAGI\Call\Peer;
use PAGI\Call\CallerId;

abstract class PAGIApplication
{
    private $_logger;
    private $_agiClient;
    private $_call;

    public abstract function init();
    public abstract function shutdown();
    public abstract function errorHandler($type, $message, $file, $line);
    public abstract function signalHandler($signal);

    public function log($msg)
    {
        $this->_agiClient->log($msg);
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug($msg);
        }
    }

    public function getAgi()
    {
        return $this->_agiClient;
    }

    public function __construct(array $properties = array())
    {
        if (isset($properties['log4php.properties'])) {
            \Logger::configure($properties['log4php.properties']);
        }
        $this->_logger = \Logger::getLogger('Pagi.PAGIApplication');
        $this->_agiClient = ClientImpl::getInstance($properties);
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