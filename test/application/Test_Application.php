<?php
/**
 * This class will test the pagi applicaiton.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Application
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

use Psr\Log\NullLogger;

/**
 * This class will test the pagi applicaiton.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Application
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_Application extends \PHPUnit_Framework_TestCase
{
    private $_properties = array();

    public function setUp()
    {
        $this->_properties = array();
    }

    /**
     * @test
     */
    public function can_app()
    {
        global $standardAGIStart;
        setFgetsMock($standardAGIStart, array());
        $this->_properties['pagiClient'] = \PAGI\Client\Impl\ClientImpl::getInstance($this->_properties);
        $application = new MyPAGIApplication($this->_properties);
        $application->setLogger(new NullLogger);
        $refObject = new \ReflectionObject($application);
        $refMethod = $refObject->getMethod('getAgi');
        $refMethod->setAccessible(true);
        $agi = $refMethod->invoke($application);
        $this->assertTrue($agi instanceof \PAGI\Client\Impl\ClientImpl);
    }
}

class MyPAGIApplication extends \PAGI\Application\PAGIApplication
{
    public function init()
    {

    }
    public function shutdown()
    {

    }
    public function run()
    {

    }
    public function errorHandler($type, $message, $file, $line)
    {

    }
    public function signalHandler($signal)
    {

    }

}
}