<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\CallerId;

use PAGI\Client\ClientInterface;

/**
 * AGI Caller id facade.
 */
class CallerIdFacade implements CallerIdInterface
{
    /**
     * Instance of client to access caller id variables.
     *
     * @var ClientInterface
     */
    private $client;

    /**
     * Constructor.
     *
     * @param ClientInterface $client AGI Client to use
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function setANI($value)
    {
        $this->setCallerIdVariable('ani', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getANI()
    {
        return $this->getCallerIdVariable('ani');
    }

    /**
     * {@inheritdoc}
     */
    public function setDNID($value)
    {
        $this->setCallerIdVariable('dnid', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getDNID()
    {
        return $this->getCallerIdVariable('dnid');
    }

    /**
     * {@inheritdoc}
     */
    public function setRDNIS($value)
    {
        $this->setCallerIdVariable('rdnis', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getRDNIS()
    {
        return $this->getCallerIdVariable('rdnis');
    }

    /**
     * {@inheritdoc}
     */
    public function setName($value)
    {
        $num = $this->getNumber();
        $this->setCallerIdVariable('name', $value);
        $this->setCallerIdVariable('all', sprintf('%s<%s>', $value, $num));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getCallerIdVariable('name');
    }

    /**
     * {@inheritdoc}
     */
    public function getNumber()
    {
        return $this->getCallerIdVariable('num');
    }

    /**
     * {@inheritdoc}
     */
    public function setNumber($value)
    {
        $name = $this->getName();
        $this->setCallerIdVariable('num', $value);
        $this->setCallerIdVariable('all', sprintf('%s<%s>', $name, $value));
    }

    /**
     * Access agi client to get the variables.
     *
     * @param string $name Variable name
     *
     * @return string
     */
    protected function getCallerIdVariable($name)
    {
        return $this->client->getFullVariable(sprint('CALLERID(%s)', $name));
    }

    /**
     * Access agi client to set the variable.
     *
     * @param string $name  Variable name
     * @param string $value Value
     */
    protected function setCallerIdVariable($name, $value)
    {
        $this->client->setVariable(sprint('CALLERID(%s)', $name), $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setCallerPres($presentationMode)
    {
        $this->client->exec('SET', array(sprintf('CALLERPRES()=%s', $presentationMode)));
    }

    /**
     * Standard procedure.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('[ CallerID: number: %s name: %s dnid: %s rdnis: %s ani: %s ]',
            $this->getNumber(),
            $this->getName(),
            $this->getDNID((),
            $this->getRDNIS(),
            $this->getANI()
        );
    }
}
