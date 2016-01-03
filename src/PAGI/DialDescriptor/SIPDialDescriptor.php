<?php
/**
 * SIP Dial Descriptor class.
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
 * SIP Dial Descriptor class.
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
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
     * (non-PHPdoc)
     * @see DialDescriptor::getTechnology()
     */
    public function getTechnology()
    {
        return self::TECHNOLOGY;
    }

    /**
     * (non-PHPdoc)
     * @see DialDescriptor::getChannelDescriptor()
     */
    public function getChannelDescriptor()
    {
        $descriptor = self::TECHNOLOGY .'/' .$this->target;

        if (null !== $this->provider) {
            $descriptor .= '@' .$this->provider;
        }

        return $descriptor;
    }

    /**
     * Class constructor.
     *
     * @param string $target dial target
     */
    public function __construct($target, $provider)
    {
        $this->target = $target;
        $this->provider = $provider;
    }

    /**
     * Set SIP provider.
     *
     * @param string $provider SIP provider
     *
     * @return void
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }
}
