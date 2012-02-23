<?php
/**
 * This class will test the agi client mock
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Mock
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

/**
 * This class will test the agi client mock
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Mock
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_Mock extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function cannot_read()
    {
        $variables = array(
            'agi_request' => 'netlabs-all.php',
            'agi_channel' => 'SIP/administracion-00803890',
            'agi_language' => 'ar',
            'agi_type' => 'SIP',
            'agi_uniqueid' => '1330012581.77',
            'agi_version' => '1.6.0.9',
            'agi_callerid' => '40',
            'agi_calleridname' => 'Admin',
            'agi_callingpres' => '1',
            'agi_callingani2' => '0',
            'agi_callington' => '0',
            'agi_callingtns' => '0',
            'agi_dnid' => '45155249',
            'agi_rdnis' => 'unknown',
            'agi_context' => 'netlabs',
            'agi_extension' => '45155249',
            'agi_priority' => '1',
            'agi_enhanced' => '0.0',
            'agi_accountcode' => '',
            'agi_threadid' => '1095317840'
        );

        $result = array('200 result=48 endpos=1');
        $mock = new PAGI\Client\Impl\MockedClientImpl($variables, $result);
        //$mock->open();
        $result = $mock->streamFile('blah', '01234567890*#');
        $this->assertFalse($result->isTimeout());
        $this->assertEquals($result->getDigitsCount(), 1);
        $this->assertEquals($result->getDigits(), '0');
        //$mock->close();
    }
}