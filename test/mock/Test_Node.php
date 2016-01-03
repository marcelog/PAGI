<?php
/**
 * This class will test the node mock
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
use PAGI\Client\Impl\MockedClientImpl;
use PAGI\Node\MockedNode;
use PAGI\Node\Node;

/**
 * This class will test the node mock
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
class Test_MockedNode extends PHPUnit_Framework_TestCase
{
    private $properties = array();
    private $client;

    public function setUp()
    {
        $this->properties = array();
        $this->client = new MockedClientImpl($this->properties);
    }

    /**
     * @test
     */
    public function can_assert_on_client_on_valid_input()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->runWithInput('1')
            ->doBeforeValidInput(function (Node $node) {
                $client = $node->getClient()->assert('playDialTone');
            })
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(1)
            ->validateInputWith(
    			'succeeded',
                function (Node $node) {
                    return true;
                },
                'invalid'
            )
            ->saySound('prompt')
            ->executeOnValidInput(function(Node $node) {
                $node->getClient()->playDialTone();
            })
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_assert_on_client_on_failed_input()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->runWithInput('1')
            ->doBeforeFailedInput(function (Node $node) {
                $client = $node->getClient()->assert('playBusyTone');
            })
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(1)
            ->validateInputWith(
    			'fails',
                function (Node $node) {
                    return false;
                },
                'invalid'
            )
            ->saySound('prompt')
            ->executeOnInputFailed(function(Node $node) {
                $node->getClient()->playBusyTone();
            })
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_skip_input_on_uninterruptable_message()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->runWithInput('1')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->unInterruptablePrompts()
            ->expectExactly(1)
            ->saySound('prompt')
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_consume_whitespace_as_no_input()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->runWithInput('     ')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(3)
            ->saySound('prompt')
            ->playOnNoInput('no-input')
            ->run()
        ;
    }

    /**
     * @test
     * @expectedException PAGI\Exception\MockedException
     */
    public function can_assert_wrong_state()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertCancelled()
            ->runWithInput('*')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(1)
            ->run()
        ;
    }

    /**
     * @test
     * @expectedException PAGI\Exception\MockedException
     */
    public function can_assert_sound_not_played()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertSaySound('max-attempts', 1)
            ->assertSaySound('no-input', 1)
            ->assertSaySound('prompt', 99)
            ->assertMaxInputAttemptsReached()
            ->runWithInput('1')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(1)
            ->validateInputWith(
    			'fails',
                function (Node $node) {
                    return false;
                },
                'invalid'
            )
            ->maxAttemptsForInput(3)
            ->saySound('prompt')
            ->playOnNoInput('no-input')
            ->playOnMaxValidInputAttempts('max-attempts')
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_assert_say_digits()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertSayDigits(123, 1)
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->sayDigits(123)
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_assert_say_number()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertSayNumber(1122, 1)
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->sayNumber(1122)
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_assert_say_datetime()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertSayDateTime(3, 'aa', 1)
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->sayDateTime(3, 'aa')
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_assert_play_sound()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertSaySound('max-attempts', 1)
            ->assertSaySound('no-input', 1)
            ->assertSaySound('prompt', 3)
            ->assertMaxInputAttemptsReached()
            ->runWithInput('1')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(1)
            ->validateInputWith(
    			'fails',
                function (Node $node) {
                    return false;
                },
                'invalid'
            )
            ->maxAttemptsForInput(3)
            ->saySound('prompt')
            ->playOnNoInput('no-input')
            ->playOnMaxValidInputAttempts('max-attempts')
            ->run()
        ;
    }
    /**
     * @test
     */
    public function can_assert_max_attempts_reached()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertMaxInputAttemptsReached()
            ->runWithInput('111')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(1)
            ->validateInputWith('fails', function (Node $node) { return false; })
            ->maxAttemptsForInput(3)
            ->run()
        ;
    }

    /**
	 * @test
     */
    public function can_assert_complete_node()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertComplete()
            ->runWithInput('12345678901#')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectAtLeast(10)
            ->endInputWith(Node::DTMF_HASH)
            ->expectAtMost(12)
            ->run()
        ;
    }

    /**
	 * @test
     */
    public function can_assert_cancelled_node()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->assertCancelled()
            ->runWithInput('*')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->cancelWith(Node::DTMF_STAR)
            ->expectExactly(1)
            ->run()
        ;
    }

    /**
     * @test
     */
    public function can_skip_input_on_non_interrupt_digit_input()
    {
        $this->client
            ->onCreateNode(__METHOD__)
            ->runWithInput('X X')
        ;
        $node = $this->client
            ->createNode(__METHOD__)
            ->expectExactly(1)
            ->saySound('prompt')
            ->run()
        ;
    }
}