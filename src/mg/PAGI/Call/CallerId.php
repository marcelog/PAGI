<?php

namespace PAMI\Call;

class CallerId
{
    private $_number;
    private $_name;

    public function getNumber()
    {
        return $this->_number;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function __construct($number, $name)
    {
        $this->_number = $number;
        $this->_name = $name;
    }
}