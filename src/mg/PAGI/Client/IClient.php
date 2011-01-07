<?php
namespace PAGI\Client;

interface IClient
{
    public function getChannel();
    public function getLanguage();
    public function getType();
    public function getUniqueId();
    public function getVersion();
    public function getCallerId();
    public function getCallerIdName();
    public function getCallingPres();
    public function getCallingAni2();
    public function getCallingTon();
    public function getCallingTns();
    public function getDNID();
    public function getContext();
    public function getRDNIS();
    public function getRequest();
    public function getDNIS();
    public function getThreadId();
    public function getAccountCode();
    public function getEnhanced();
    public function getPriority();
}
