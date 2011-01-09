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
    public function setANI($value);
    public function getANI();
    public function setDNID($value);
    public function getDNID();
    public function setRDNIS($value);
    public function getRDNIS();
    public function setName($value);
    public function getName();
    public function getNumber();
    public function setNumber($value);
}