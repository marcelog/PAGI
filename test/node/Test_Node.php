<?php
/**
 * This class will test the pagi nodes
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Node
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
use PAGI\Node\Node;

/**
 * This class will test the pagi nodes
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Node
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 *
 * @backupStaticAttributes disabled
 * @backupGlobals disabled
 */
class Test_Node extends PHPUnit_Framework_TestCase
{
    protected function createNode($name = 'test')
    {
        return Node::create(
            $name, new PAGI\Client\Impl\MockedClientImpl(array(
                'log4php.properties' => RESOURCES_DIR . DIRECTORY_SEPARATOR . 'log4php.properties',
                'variables' => array(),
                'resultStrings' => array()
            ))
        );
    }

    /**
     * @test
     */
    public function can_carry_state()
    {
        $node = $this->createNode();
        $this->assertFalse($node->hasCustomData('key'));
        $node->saveCustomData('key', 'value');
        $this->assertTrue($node->hasCustomData('key'));
        $this->assertEquals($node->getCustomData('key'), 'value');
        $node->delCustomData('key');
        $this->assertFalse($node->hasCustomData('key'));
    }

    /**
     * @test
     */
    public function can_interrupt_prompt()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(false)
            ->onSayNumber(false)
            ->onSayDigits(true, '#')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('sayNumber', array(12, Node::DTMF_ANY))
            ->assert('sayDigits', array(99, Node::DTMF_ANY))
        ;
        $node
            ->saySound('you-have')
            ->sayNumber(12)
            ->sayDigits(99)
            ->sayDateTime(444, 'format')
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_say_uninterruptable_prompt()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(true, '#')
            ->onSayNumber(true, '#')
            ->onSayDigits(true, '#')
            ->onSayDateTime(true, '#')
            ->assert('streamFile', array('you-have', Node::DTMF_NONE))
            ->assert('sayNumber', array(12, Node::DTMF_NONE))
            ->assert('sayDigits', array(99, Node::DTMF_NONE))
            ->assert('sayDateTime', array(444, 'format', Node::DTMF_NONE))
        ;
        $node
            ->unInterruptablePrompts()
            ->saySound('you-have')
            ->sayNumber(12)
            ->sayDigits(99)
            ->sayDateTime(444, 'format')
            ->run()
        ;
        $this->assertTrue($node->isTimeout());
    }

    /**
     * @test
     */
    public function can_say_prompt_in_order()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(false)
            ->onSayNumber(false)
            ->onSayDigits(false)
            ->onSayDateTime(false)
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('sayNumber', array(12, Node::DTMF_ANY))
            ->assert('sayDigits', array(99, Node::DTMF_ANY))
            ->assert('sayDateTime', array(444, 'format', Node::DTMF_ANY))
        ;
        $node
            ->saySound('you-have')
            ->sayNumber(12)
            ->sayDigits(99)
            ->sayDateTime(444, 'format')
            ->run()
        ;
        $this->assertTrue($node->isTimeout());
    }
}