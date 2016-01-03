<?php
/**
 * Dial Descriptor abstract class.
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
 * Dial Descriptor abstract class.
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
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
