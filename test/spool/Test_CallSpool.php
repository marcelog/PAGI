<?php
/**
 * This class will test the call spool.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Spool
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/
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

namespace PAGI\Client\Impl {
/**
 * This class will test the call spool.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Spool
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_CallSpool extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array(
            'log4php.properties' => RESOURCES_DIR . DIRECTORY_SEPARATOR . 'log4php.properties'
        );
    }

    /**
     * @test
     */
    public function can_get_instance()
    {
        $props = array(
            'tmpDir' => '/tmp',
            'spoolDir' => '/tmp'
        );
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props);
        $spool = \PAGI\CallSpool\Impl\CallSpoolImpl::getInstance($props); // should return the same instance.
    }
}
}