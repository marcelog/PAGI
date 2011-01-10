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
namespace PAGI\CallerId;

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
interface ICallerId
{
    /**
     * Sets caller id ani. CALLERID(ani).
     *
     * @param string $value ANI.
     *
     * @return void
     */
    public function setANI($value);

    /**
     * Returns caller id ani. CALLERID(ani)
     *
     * @return string
     */
    public function getANI();

    /**
     * Sets caller id dnid. CALLERID(dnid)
     *
     * @param string $value DNID.
     *
     * @return void
     */
    public function setDNID($value);

    /**
     * Returns caller id dnid. CALLERID(dnid)
     *
     * @return string
     */
    public function getDNID();

    /**
     * Sets caller id rdnis. CALLERID(rdnis)
     *
     * @param string $value RDNIS.
     *
     * @return void
     */
    public function setRDNIS($value);

    /**
     * Returns caller id rdnis. CALLERID(rdnis)
     *
     * @return string
     */
    public function getRDNIS();

    /**
     * Sets caller id name. CALLERID(name)
     *
     * @param string $value Name.
     *
     * @return void
     */
    public function setName($value);

    /**
     * Returns caller id name. CALLERID(name)
     *
     * @return string
     */
    public function getName();

    /**
     * Returns caller id number. CALLERID(num)
     *
     * @return string
     */
    public function getNumber();

    /**
     * Sets caller id number. CALLERID(num)
     *
     * @param string $value Number.
     *
     * @return void
     */
    public function setNumber($value);
}