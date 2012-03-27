<?php
/**
 * A node controller, used to execute a series of nodes while evaluating
 * their output.
 *
 * PHP Version 5.3
 *
 * @category PAGI
 * @package  Node
 * @author   Marcelo Gornstein <marcelog@gmail.com>
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
namespace PAGI\Node;

use PAGI\Client\IClient;
use PAGI\Node\Exception\NodeException;

/**
 * A node controller, used to execute a series of nodes while evaluating
 * their output.
 *
 * @category PAGI
 * @package  Node
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
class NodeController
{
    /**
     * All registered nodes.
     * @var PAGI\Node\Node[]
     */
    protected $nodes = array();

    /**
     * All registered node results.
     * @var PAGI\Node\NodeActionCommand[]
     */
    protected $nodeResults = array();

    /**
     * The PAGI client in use.
     * @var PAGI\Client\IClient
     */
    protected $client;

    /**
     * Asterisk logger instance to use.
     * @var PAGI\Logger\Asterisk\IAsteriskLogger
     */
    protected $logger;

    /**
     * Runs a node and process the result.
     *
     * @param string $name Node to run.
     *
     * @return void
     */
    public function jumpTo($name)
    {
        if (!isset($this->nodes[$name])) {
            throw new NodeException("Unknown node: $name");
        }
        // Cant make this recursive because php does not support tail
        // recursion optimization.
        while($name !== false) {
            $node = $this->nodes[$name];
            $this->logger->debug("Running $name");
            $node->run();
            $name = $this->processNodeResult($node);
        }
    }

    /**
     * Process the result of the given node. Returns false if no other nodes
     * should be run, or a string with the next node name.
     *
     * @param PAGI\Node\Node $node Node that was run.
     *
     * @return string|false
     */
    protected function processNodeResult(Node $node)
    {
        $ret = false;
        $name = $node->getName();
        if (isset($this->nodeResults[$name])) {
            foreach ($this->nodeResults[$name] as $resultInfo) {
                if ($resultInfo->appliesTo($node)) {
                    if ($resultInfo->isActionHangup()) {
                        $this->logger->debug("Hanging up after $name");
                        $this->client->hangup();
                    } else if($resultInfo->isActionJumpTo()) {
                        $data = $resultInfo->getActionData();
                        $nodeName = $data['nodeName'];
                        $this->logger->debug("Jumping from $name to $nodeName");
                        $ret = $nodeName;
                    } else if ($resultInfo->isActionExecute()) {
                        $this->logger->debug("Executing callback after $name");
                        $data = $resultInfo->getActionData();
                        $callback = $data['callback'];
                        $callback($node);
                    }
                }
            }
        }
        return $ret;
    }

    /**
     * Registers a new node result to be taken into account when the given node
     * is ran.
     *
     * @param string $name
     *
     * @return PAGI\Node\NodeActionCommand
     */
    public function registerResult($name)
    {
        $nodeActionCommand = new NodeActionCommand();
        if (!isset($this->nodeResults[$name])) {
            $this->nodeResults[$name] = array();
        }
        $this->nodeResults[$name][] = $nodeActionCommand;
        return $nodeActionCommand->whenNode($name);
    }

    /**
     * Registers a new node in the application. Returns the created node.
     *
     * @param string $name The node to be registered
     *
     * @return PAGI\Node\Node
     */
    public function register($name)
    {
        $node = $this->client->createNode($name);
        $this->nodes[$name] = $node;
        return $node;
    }

    /**
     * Constructor.
     *
     * @param PAGI\Client\IClient $client
     *
     * @return void
     */
    public function __construct(IClient $client)
    {
        $this->client = $client;
        $this->logger = $this->client->getAsteriskLogger();
    }
}