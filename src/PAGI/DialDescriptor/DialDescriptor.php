<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\DialDescriptor;

/**
 * Dial Descriptor abstract class.
 */
abstract class DialDescriptor
{
    /**
     * Target to dial.
     *
     * @var string
     */
    protected $target;

    /**
     * Get channel descriptor representation.
     *
     * @return string
     */
    abstract public function getChannelDescriptor();

    /**
     * Get channel technology.
     *
     * @return string
     */
    abstract public function getTechnology();

    /**
     * Set dial target.
     *
     * @param string $target dial target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }
}
