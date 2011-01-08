<?php
namespace PAGI\Call;

use PAGI\Call\Exception\UnknownPeerTypeException;

class Peer
{
    const DAHDI = 0;
    const SIP = 1;

    private $_id;
    private $_type;
    private $_channel;

    public function getId()
    {
        return $this->_id;
    }

    protected function getType()
    {
        return $this->_type;
    }

    public function isSip()
    {
        return $this->_type === self::SIP;
    }

    public function isDahdi()
    {
        return $this->_type === self::DAHDI;
    }

    public function isTDM()
    {
        return $this->isDahdi();
    }

    public function getChannel()
    {
        return $this->_channel;
    }

    public function getCallerId()
    {
        return $this->_clid;
    }

    public static function getTypeFromChannel($channel)
    {
        $data = explode('/', $channel);
        switch(strtolower($data[0]))
        {
            case 'sip':
                return self::SIP;
            case 'dahdi':
                return self::DAHDI;
            default:
                throw new UnknownPeerTypeException();
        }
    }

    public function __construct($id, $channel, $callerId)
    {
        $this->_id = $id;
        $this->_type = self::getTypeFromChannel($channel);
        $this->_channel = $channel;
        $this->_clid = $callerId;
    }
}
