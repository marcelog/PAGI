<?php
/**
 * This class will test the node controller.
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
use PAGI\Node\NodeController;

/**
 * This class will test the node controller.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Test
 * @subpackage Node
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class Test_NodeController extends PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new PAGI\Client\Impl\MockedClientImpl(array(
    		'log4php.properties' => RESOURCES_DIR . DIRECTORY_SEPARATOR . 'log4php.properties',
    		'variables' => array(),
    		'resultStrings' => array()
        ));
    }

    protected function createNode($name = 'test')
    {
        return $this->client->createNode($name);
    }

    protected function createNodeController($name = 'test')
    {
        return $this->client->createNodeController($name);
    }

    /**
     * @test
     */
    public function can_detect_results_that_dont_apply_to_node()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__);
        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)->onCancel()->execute(
            function (Node $node) use ($object) {
                $object->flag = true;
            }
        );
        $controller->register(__METHOD__)->saySound('test');
        $controller->jumpTo(__METHOD__);
        $this->assertFalse($object->flag);
    }

	/**
	 * @test
	 * @expectedException PAGI\Node\Exception\NodeException
	 */
	public function cannot_jump_to_unknown_node()
	{
		$controller = $this->createNodeController(__METHOD__);
		$controller->jumpTo(__METHOD__);
	}

	/**
	 * @test
	 * @expectedException PAGI\Node\Exception\NodeException
	 */
	public function cannot_jump_to_unknown_childnode()
	{
		$controller = $this->createNodeController(__METHOD__);

		$node = $controller->register(__METHOD__ . 'node');

		$controller->registerResult($node->getName())
		           ->jumpAfterEval(function (Node $node)
		           {
			           return 'def';
		           });

		$controller->jumpTo($node->getName());
	}

	/**
	 * @test
	 * @expectedException PAGI\Node\Exception\NodeException
	 */
	public function cannot_jump_to_empty_childnode()
	{
		$controller = $this->createNodeController(__METHOD__);

		$node = $controller->register(__METHOD__ . 'node');

		$controller->registerResult($node->getName())
		           ->jumpAfterEval(function (Node $node)
		           {
			           // do nothing, happends when we don't read the docs!
		           });

		$controller->jumpTo($node->getName());
	}

    /**
     * @test
     */
    public function can_hangup()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__);

        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)
            ->onComplete()->execute(function (Node $node) {
                $node->getClient()->assert('hangup')->onHangup(true);
            })
        ;
        $controller->registerResult(__METHOD__)
            ->onComplete()
            ->hangup(16)
        ;
        $controller->register(__METHOD__)->saySound('test');
        $controller->jumpTo(__METHOD__);
    }

    /**
     * @test
     */
    public function can_jump_to_node()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__);
        $this->client->onCreateNode(__METHOD__ . '2');

        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)
            ->onComplete()->jumpTo(__METHOD__ . '2')
        ;
        $controller->registerResult(__METHOD__ . '2')->onComplete()->execute(
            function (Node $node) use ($object) {
                $object->flag = true;
            }
        );
        $controller->register(__METHOD__)->saySound('test');
        $controller->register(__METHOD__ . '2')->saySound('test2');
        $controller->jumpTo(__METHOD__);
        $this->assertTrue($object->flag);
    }

    /**
     * @test
     */
    public function can_jump_after_evaluation()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__);
        $this->client->onCreateNode('can_jump_after_evaluation2');

        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)
        ->onComplete()->jumpAfterEval(function (Node $node) {
            return 'can_jump_after_evaluation2';
        });
        $controller->registerResult('can_jump_after_evaluation2')->onComplete()->execute(
                function (Node $node) use ($object) {
            $object->flag = true;
        }
        );
        $controller->register(__METHOD__)->saySound('test');
        $controller->register('can_jump_after_evaluation2')->saySound('test2');
        $controller->jumpTo(__METHOD__);
        $this->assertTrue($object->flag);
    }

    /**
     * @test
     */
    public function can_detect_complete()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__);
        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)->onComplete()->execute(
            function (Node $node) use ($object) {
                $object->flag = true;
            }
        );
        $controller->register(__METHOD__)->saySound('test');
        $controller->jumpTo(__METHOD__);
        $this->assertTrue($object->flag);
    }

    /**
     * @test
     */
    public function can_detect_cancel()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__)->runWithInput('*');
        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)->onCancel()->execute(
            function (Node $node) use ($object) {
                $object->flag = true;
            }
        );
        $controller
            ->register(__METHOD__)
            ->saySound('test')
            ->cancelWith(Node::DTMF_STAR)
        ;
        $controller->jumpTo(__METHOD__);
        $this->assertTrue($object->flag);
    }

    /**
     * @test
     */
    public function can_detect_max_input_attempts_reached()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__)->runWithInput('123');
        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)->onMaxAttemptsReached()->execute(
            function (Node $node) use ($object) {
                $object->flag = true;
            }
        );
        $controller
            ->register(__METHOD__)
            ->saySound('test')
            ->maxAttemptsForInput(3)
            ->expectExactly(1)
            ->validateInputWith(
                'fails',
                function (Node $node) {
                    return false;
                },
                'nevermind'
            )
        ;
        $controller->jumpTo(__METHOD__);
        $this->assertTrue($object->flag);
    }

    /**
     * @test
     */
    public function can_complete_with_input()
    {
        $object = new stdClass;
        $object->flag = false;

        $this->client->onCreateNode(__METHOD__)->runWithInput('123');
        $controller = $this->createNodeController(__METHOD__);
        $controller->registerResult(__METHOD__)
            ->onComplete()
            ->withInput('3')
            ->execute(function (Node $node) use ($object) {
                $object->flag = true;
            })
        ;
        $controller
            ->register(__METHOD__)
            ->saySound('test')
            ->maxAttemptsForInput(3)
            ->expectExactly(1)
            ->validateInputWith(
                'option-valid',
                function (Node $node) {
                    return $node->getInput() == 3;
                },
                'nevermind'
            )
        ;
        $controller->jumpTo(__METHOD__);
        $this->assertTrue($object->flag);
    }
}

