<?php
namespace PAGI\Client;

class ChannelStatus
{
    const DOWN_AVAILABLE = 0;
    const DOWN_RESERVED = 1;
    const OFF_HOOK = 2;
    const DIGITS_DIALED = 3;
    const LINE_RINGING = 4;
    const REMOTE_RINGING = 5;
    const LINE_UP = 6;
    const LINE_BUSY = 7;

    public static function toString($status)
    {
        switch($status)
        {
            case self::DOWN_AVAILABLE:
                return 'Channel is down and available';
            case self::DOWN_RESERVED:
                return 'Channel is down, but reserved';
            case self::OFF_HOOK:
                return 'Channel is off hook';
            case self::DIGITS_DIALED:
                return 'Digits (or equivalent) have been dialed';
            case self::LINE_RINGING:
                return 'Line is ringing';
            case self::REMOTE_RINGING:
                return 'Remote end is ringing';
            case self::LINE_UP:
                return 'Line is up';
            case self::LINE_BUSY:
                return 'Line is busy';
            default:
                return false;
        }
    }
}