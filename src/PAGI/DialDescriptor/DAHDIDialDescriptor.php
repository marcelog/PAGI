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
 * DAHDI Dial Descriptor class.
 *
 * @see http://www.asteriskguide.com/mediawiki/index.php/Analog_Channels
 */
class DAHDIDialDescriptor extends DialDescriptor
{
    const TECHNOLOGY = 'DAHDI';

    /**
     * Channel or group identifier.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Is group identifier.
     *
     * @var Boolean
     */
    protected $isGroup;

    /**
     * In case of dialing via a group, this will use g or G so asterisk selects
     * the outgoing channel in asc or desc order.
     *
     * @var Boolean
     */
    protected $descendantOrder;

    /**
     * Class constructor.
     *
     * @param string  $target     dial target
     * @param integer $identifier channel/group identifier
     * @param Boolean $isGroup    whether identifier refs a group
     */
    public function __construct($target, $identifier, $isGroup = true, $descendantOrder = true)
    {
        $this->target = $target;
        $this->identifier = $identifier;
        $this->isGroup = $isGroup;
        $this->descendantOrder = $descendantOrder;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannelDescriptor()
    {
        $descriptor = self::TECHNOLOGY.'/';

        if ($this->isGroup) {
            $descriptor .= $this->descendantOrder ? 'G' : 'g';
        }

        $descriptor .= $this->identifier.'/'.$this->target;

        return $descriptor;
    }

    /**
     * {@inheritdoc}
     */
    public function getTechnology()
    {
        return self::TECHNOLOGY;
    }

    /**
     * Set group to use.
     *
     * @param integer $group group of channels to use
     */
    public function setGroup($group)
    {
        $this->identifier = $group;
        $this->isGroup = true;
    }

    /**
     * Set channel to use.
     *
     * @param integer $channel channel to use
     */
    public function setChannel($channel)
    {
        $this->identifier = $channel;
        $this->isGroup = false;
    }
}
