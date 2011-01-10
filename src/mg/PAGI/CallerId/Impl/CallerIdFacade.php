<?php
/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Callerid
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\CallerId\Impl;

use PAGI\CallerId\ICallerId;
use PAGI\Client\IClient;

/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Callerid
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
class CallerIdFacade implements ICallerId
{
    /**
     * Instance of client to access caller id variables.
     * @var IClient
     */
    private $_client;

    /**
     * Current instance.
     * @var CallerIdFacade
     */
    private static $_instance = false;

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setANI()
     */
    public function setANI($value)
    {
        $this->setCallerIdVariable('ani', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getANI()
     */
    public function getANI()
    {
        return $this->getCallerIdVariable('ani');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setDNID()
     */
    public function setDNID($value)
    {
        $this->setCallerIdVariable('dnid', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getDNID()
     */
    public function getDNID()
    {
        return $this->getCallerIdVariable('dnid');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setRDNIS()
     */
    public function setRDNIS($value)
    {
        $this->setCallerIdVariable('rdnis', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getRDNIS()
     */
    public function getRDNIS()
    {
        return $this->getCallerIdVariable('rdnis');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setName()
     */
    public function setName($value)
    {
        $this->setCallerIdVariable('name', $value);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getName()
     */
    public function getName()
    {
        return $this->getCallerIdVariable('name');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::getNumber()
     */
    public function getNumber()
    {
        return $this->getCallerIdVariable('num');
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallerId.ICallerId::setNumber()
     */
    public function setNumber($value)
    {
        $this->setCallerIdVariable('num', $value);
    }

    /**
     * Access AGI client to get the variables.
     *
     * @param string $name Variable name.
     *
     * @return string
     */
    protected function getCallerIdVariable($name)
    {
        return $this->_client->getFullVariable('CALLERID(' . $name . ')');
    }

    /**
     * Access AGI client to set the variable.
     *
     * @param string $name  Variable name.
     * @param string $value Value.
     *
     * @return void
     */
    protected function setCallerIdVariable($name, $value)
    {
        $this->_client->setVariable('CALLERID(' . $name . ')', $value);
    }

    /**
     * Standard procedure.
     *
     * @return string
     */
    public function __toString()
    {
        return
            '[ CallerID: '
            . ' number: ' . $this->getNumber()
            . ' name: ' . $this->getName()
            . ' dnid: ' . $this->getDNID()
            . ' rdnis: ' . $this->getRDNIS()
            . ' ani: ' . $this->getANI()
            . ']'
        ;
    }

    /**
     * Returns an instance for this facade.
     *
     * @param IClient $client AGI Client to use.
     *
     * @return CallerIdFacade
     */
    public static function getInstance(IClient $client = null)
    {
        if (self::$_instance === false) {
            $ret = new CallerIdFacade($client);
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }

    /**
     * Constructor.
     *
     * @param IClient $client AGI Client to use.
     *
     * @return void
     */
    protected function __construct(IClient $client)
    {
        $this->_client = $client;
    }
}