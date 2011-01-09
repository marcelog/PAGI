<?php
namespace PAGI\CDR;

use PAGI\Client\IClient;

interface ICDR
{
    public function setUserfield($value);
    public function getUserfield();
    public function getUniqueId();
    public function setAccountCode($value);
    public function getAccountCode();
    public function getAMAFlags();
    public function getStatus();
    public function getAnswerLength();
    public function getTotalLength();
    public function getEndTime();
    public function getAnswerTime();
    public function getStartTime();
    public function getLastAppData();
    public function getLastApp();
    public function getChannel();
    public function getDestinationChannel();
    public function getCallerId();
    public function getSource();
    public function getDestination();
    public function getDestinationContext();
    public function getCustom($name);
    public function setCustom($name, $value);
    public static function getInstance(IClient $client = null);
}
