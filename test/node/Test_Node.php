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
namespace {
    $mockTime = false;
    $mockTimeValues = array();
}

namespace PAGI\Node {
    function time()
    {
        global $mockTime;
        global $mockTimeValues;

        if (!$mockTime) {
            return \time();
        }
        return array_shift($mockTimeValues);
    }
}

namespace {

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
    public function can_execute_validators()
    {
        $validators = array(
            'validator1' => Node::createValidatorInfo(
                function (Node $node) {
                    return true;
                }
            ),
            'validator2' => Node::createValidatorInfo(
                function ($node) {
                    return $node->getInput() > 1;
                },
                'sound2'
            ),
            'validator3' => Node::createValidatorInfo(
                function ($node) {
                    return $node->getInput() > 2;
                },
                array('sound2', 'sound3')
            )
        );
        $node = $this->createNode();
        $node->getClient()
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('streamFile', array('sound2', Node::DTMF_ANY))
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('streamFile', array('sound2', Node::DTMF_ANY))
            ->assert('streamFile', array('sound3', Node::DTMF_ANY))
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->onStreamFile(true, '1')
            ->onStreamFile(false, 'sound2')
            ->onStreamFile(true, '2')
            ->onStreamFile(false, 'sound2')
            ->onStreamFile(false, 'sound3')
            ->onStreamFile(true, '3')
            ;
        $node
            ->saySound('you-have')
            ->expectExactly(1)
            ->maxAttemptsForInput(5)
            ->loadValidatorsFrom($validators)
            ->run()
        ;
        $this->assertTrue($node->hasInput());
        $this->assertEquals($node->getInput(), '3');
        $this->assertTrue($node->isComplete());
    }

    /**
     * @test
     */
    public function can_create_validator_info()
    {
        $validatorInfo = Node::createValidatorInfo(
            function ($node) { return true; }, 'sound'
        );
        $this->assertEquals($validatorInfo['soundOnError'], 'sound');
        $this->assertTrue($validatorInfo['callback'](null));
    }

    /**
     * @test
     */
    public function can_honor_max_time_for_input()
    {
        global $mockTime;
        global $mockTimeValues;

        $mockTime = true;
        $now = time();
        $mockTimeValues[] = $now; // start
        $mockTimeValues[] = $now; // 1st check
        $mockTimeValues[] = $now + 5; // after 1st digit

        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(true, '1')
            ->onWaitDigit(true, '2')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
        ;
        $node
            ->saySound('you-have')
            ->expectExactly(3)
            ->maxTotalTimeForInput(5000)
            ->run()
        ;
        $this->assertTrue($node->isTimeout());
        $mockTime = false;
        $mockTimeValues = array();
    }

    /**
     * @test
     */
    public function can_execute_on_valid_input()
    {
        $helper = new \stdClass;
        $helper->flag = false;

        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(true, '1')
            ->onWaitDigit(true, '2')
            ->onWaitDigit(true, '3')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
        ;
        $node
            ->expectExactly(3)
            ->maxAttemptsForInput(2)
            ->executeOnValidInput(function ($node) use ($helper) {
                $helper->flag = true;
            })
            ->saySound('you-have')
            ->run()
        ;
        $this->assertTrue($helper->flag);
    }

    /**
     * @test
     */
    public function can_execute_on_failed_input()
    {
        $helper = new \stdClass;
        $helper->flag = false;

        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(false)
            ->onWaitDigit(false)
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
        ;
        $node
            ->expectExactly(3)
            ->executeOnInputFailed(function ($node) use ($helper) {
                $helper->flag = true;
            })
            ->saySound('you-have')
            ->run()
        ;
        $this->assertTrue($helper->flag);
    }

    /**
     * @test
     */
    public function can_play_on_max_attempts_reached()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(false)
            ->onWaitDigit(false)
            ->onStreamFile(false)
            ->onWaitDigit(false)
            ->onStreamFile(false)
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('streamFile', array('max-attempts-reached', Node::DTMF_ANY))
        ;
        $node
            ->expectAtLeast(3)
            ->expectAtMost(5)
            ->playOnMaxValidInputAttempts('max-attempts-reached')
            ->maxAttemptsForInput(2)
            ->saySound('you-have')
            ->run()
        ;
        $this->assertTrue($node->maxInputsReached());
        $this->assertEquals($node->getInput(), '');
        $this->assertFalse($node->hasInput());
    }

    /**
     * @test
     */
    public function can_cancel_and_retry_input()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(true, '1')
            ->onWaitDigit(true, '2')
            ->onWaitDigit(true, '3')
            ->onWaitDigit(true, '*')
            ->onStreamFile(true, '#')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
        ;
        $node
            ->expectAtLeast(3)
            ->expectAtMost(5)
            ->maxAttemptsForInput(2)
            ->cancelWithInputRetriesInput()
            ->cancelWith(Node::DTMF_STAR)
            ->endInputWith(Node::DTMF_HASH)
            ->saySound('you-have')
            ->run()
        ;
        $this->assertTrue($node->maxInputsReached());
        $this->assertEquals($node->getInput(), '');
        $this->assertFalse($node->hasInput());
    }

    /**
     * test
     */
    public function can_cancel_without_retrying_input()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(true, '1')
            ->onWaitDigit(true, '2')
            ->onWaitDigit(true, '3')
            ->onWaitDigit(true, '*')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
        ;
        $node
            ->expectAtLeast(3)
            ->expectAtMost(5)
            ->maxAttemptsForInput(2)
            ->cancelWith(Node::DTMF_STAR)
            ->endInputWith(Node::DTMF_HASH)
            ->saySound('you-have')
            ->run()
        ;
        $this->assertTrue($node->wasCancelled());
        $this->assertEquals($node->getInput(), '123');
        $this->assertTrue($node->hasInput());
    }

	/**
     * @test
     */
    public function can_play_on_no_input()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(false)
            ->onStreamFile(false)
            ->onStreamFile(false)
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('streamFile', array('try-again', Node::DTMF_ANY))
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ;
        $node
            ->maxAttemptsForInput(2)
            ->playOnNoInput('try-again')
            ->saySound('you-have')
            ->run()
        ;
        $this->assertTrue($node->isTimeout());
        $this->assertEquals($node->getInput(), '');
        $this->assertFalse($node->hasInput());
    }

    /**
     * @test
     */
    public function can_end_input()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(false)
            ->onSayNumber(false)
            ->onSayDigits(true, '1')
            ->onWaitDigit(true, '2')
            ->onWaitDigit(true, '3')
            ->onWaitDigit(true, '#')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('sayNumber', array(12, Node::DTMF_ANY))
            ->assert('sayDigits', array(99, Node::DTMF_ANY))
        ;
        $node
            ->playOnNoInput('try-again')
            ->expectAtLeast(3)
            ->expectAtMost(5)
            ->endInputWith(Node::DTMF_HASH)
            ->saySound('you-have')
            ->sayNumber(12)
            ->sayDigits(99)
            ->sayDateTime(444, 'format')
            ->run()
        ;
        $this->assertTrue($node->isComplete());
        $this->assertEquals($node->getInput(), '123');
        $this->assertTrue($node->hasInput());
    }

    /**
     * @test
     */
    public function can_cancel_node()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(false)
            ->onSayNumber(false)
            ->onSayDigits(true, '*')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('sayNumber', array(12, Node::DTMF_ANY))
            ->assert('sayDigits', array(99, Node::DTMF_ANY))
        ;
        $node
            ->playOnNoInput('try-again')
            ->cancelWith(Node::DTMF_STAR)
            ->saySound('you-have')
            ->sayNumber(12)
            ->sayDigits(99)
            ->sayDateTime(444, 'format')
            ->run()
        ;
        $this->assertTrue($node->wasCancelled());
        $this->assertEquals($node->getInput(), '');
        $this->assertFalse($node->hasInput());
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
            ->playOnNoInput('try-again')
            ->expectAtLeast(1)
            ->saySound('you-have')
            ->sayNumber(12)
            ->sayDigits(99)
            ->sayDateTime(444, 'format')
            ->run()
        ;
        $this->assertEquals($node->getInput(), '#');
        $this->assertTrue($node->isComplete());
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
            ->playOnNoInput('try-again')
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
            ->playOnNoInput('try-again')
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
    public function can_set_infinite_time_between_digits()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(true, '1')
            ->onWaitDigit(true, '2')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('waitDigit', array(-1))
        ;
        $node
            ->saySound('you-have')
            ->expectExactly(2)
            ->maxTimeBetweenDigits(Node::TIME_INFINITE)
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_set_time_between_digits()
    {
        $node = $this->createNode();
        $node->getClient()
            ->onStreamFile(true, '1')
            ->onWaitDigit(true, '2')
            ->assert('streamFile', array('you-have', Node::DTMF_ANY))
            ->assert('waitDigit', array(1052))
        ;
        $node
            ->saySound('you-have')
            ->expectExactly(2)
            ->maxTimeBetweenDigits(1052)
            ->run()
        ;
    }
}
}
