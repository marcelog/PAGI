<?php
namespace PAGI\Application;

use PAGI\Client\Impl\ClientImpl;
use PAGI\Call\Call;
use PAGI\Call\Peer;
use PAGI\Call\CallerId;

abstract class PAGIApplication
{
    private $_agiClient;
    private $_call;

    protected abstract function init();
    protected abstract function shutdown();


    protected function __construct()
    {
        $this->_agiClient = ClientImpl::getInstance();
        //$callingChannel = $
//        $caller = new Peer(
//            $this->_agiClient->
//        );
        register_shutdown_function(array($this), 'shutdown');
    }
}