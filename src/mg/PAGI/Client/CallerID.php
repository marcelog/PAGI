<?php
/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\Client;

/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Client
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
class CallerID
{
    /**
     * Instance of client to access caller id variables.
     * @var IClient
     */
    private $_client;

    /**
     * Sets caller id ani.
     *
     * @param string $value ANI.
     *
     * @return void
     */
    public function setANI($value)
    {
        $this->setCallerIdVariable('ani', $value);
    }

    /**
     * Returns caller id ani.
     *
     * @return string
     */
    public function getANI()
    {
        return $this->getCallerIdVariable('ani');
    }

    /**
     * Sets caller id dnid.
     *
     * @param string $value DNID.
     *
     * @return void
     */
    public function setDNID($value)
    {
        $this->setCallerIdVariable('dnid', $value);
    }

    /**
     * Returns caller id dnid.
     *
     * @return string
     */
    public function getDNID()
    {
        return $this->getCallerIdVariable('dnid');
    }

    /**
     * Sets caller id rdnis.
     *
     * @param string $value RDNIS.
     *
     * @return void
     */
    public function setRDNIS($value)
    {
        $this->setCallerIdVariable('rdnis', $value);
    }

    /**
     * Returns caller id rdnis.
     *
     * @return string
     */
    public function getRDNIS()
    {
        return $this->getCallerIdVariable('rdnis');
    }

    /**
     * Sets caller id name.
     *
     * @param string $value Name.
     *
     * @return void
     */
    public function setName($value)
    {
        $this->setCallerIdVariable('name', $value);
    }

    /**
     * Returns caller id name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getCallerIdVariable('name');
    }

    /**
     * Returns caller id number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->getCallerIdVariable('num');
    }

    /**
     * Sets caller id number.
     *
     * @param string $value Number.
     *
     * @return void
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
     * Constructor.
     *
     * @param IClient $client AGI Client to use.
     *
     * @return void
     */
    public function __construct(IClient $client)
    {
        $this->_client = $client;
    }
}