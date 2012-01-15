<?php
/**
 * DAHDI Dial Descriptor class.
 *
 * PHP Version 5.3
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/PAGI/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
namespace PAGI\DialDescriptor;

/**
 * DAHDI Dial Descriptor class.
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 *
 * @todo     shall we include more options?
 * see http://www.asteriskguide.com/mediawiki/index.php/Analog_Channels
 **/
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
     * @var bool
     */
    protected $isGroup;

    /**
     * In case of dialing via a group, this will use g or G so asterisk selects
     * the outgoing channel in asc or desc order.
     * @var boolean
     */
    protected $descendantOrder;

    /**
     * (non-PHPdoc)
     * @see DialDescriptor::getChannelDescriptor()
     */
    public function getChannelDescriptor()
    {
        $descriptor = self::TECHNOLOGY .'/';
        if ($this->isGroup) {
            $descriptor .= $this->descendantOrder
                ? 'G'
                : 'g';
        }

        $descriptor .= $this->identifier.'/' .$this->target;

        return $descriptor;
    }

    /**
     * (non-PHPdoc)
     * @see DialDescriptor::getTechnology()
     */
    public function getTechnology()
    {
        return self::TECHNOLOGY;
    }

    /**
     * Class constructor.
     *
     * @param string  $target     dial target
     * @param integer $identifier channel/group identifier
     * @param bool    $isGroup    whether identifier refs a group
     */
    public function __construct($target, $identifier, $isGroup = true, $descendantOrder = true)
    {
        $this->target = $target;
        $this->identifier = $identifier;
        $this->isGroup = $isGroup;
        $this->descendantOrder = $descendantOrder;
    }

    /**
     * Set group to use.
     *
     * @param integer $group group of channels to use
     *
     * @return void
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
     *
     * @return void
     */
    public function setChannel($channel)
    {
        $this->identifier = $channel;
        $this->isGroup = false;
    }

}

