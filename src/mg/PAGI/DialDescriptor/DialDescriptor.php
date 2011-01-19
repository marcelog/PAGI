<?php
/**
 * Dial Descriptor abstract class.
 *
 * PHP Version 5.3
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\DialDescriptor;

/**
 * Dial Descriptor abstract class.
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
**/
abstract class DialDescriptor
{

    /**
     * Target to dial.
     *
     * @var string
     */
    protected $target;

    /**
     * Get channel descriptor representation
     *
     * @return string
     */
    public abstract function getChannelDescriptor();

    /**
     * Get channel technology.
     *
     * @return string
     */
    public abstract function getTechnology();

    /**
     * Set dial target.
     *
     * @param string $target dial target
     *
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

}
