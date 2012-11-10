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
 * SIP Dial Descriptor class.
 */
class SIPDialDescriptor extends DialDescriptor
{
    const TECHNOLOGY = 'SIP';

    /**
     * SIP provider.
     *
     * @var string
     */
    protected $provider = null;

    /**
     * Class constructor.
     *
     * @param string $target dial target
     */
    public function __construct($target, $provider)
    {
        $this->target   = $target;
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getTechnology()
    {
        return self::TECHNOLOGY;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannelDescriptor()
    {
        $descriptor = self::TECHNOLOGY.'/'.$this->target;

        if (null !== $this->provider) {
            $descriptor .= '@'.$this->provider;
        }

        return $descriptor;
    }

    /**
     * Set SIP provider.
     *
     * @param string $provider SIP provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }
}
