<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Node;

use PAGI\Client\ClientInterface;
use PAGI\Node\Exception\NodeException;

/**
 * A node controller, used to execute a series of nodes while evaluating
 * their output.
 */
class NodeController
{
    /**
     * All registered nodes.
     *
     * @var array
     */
    protected $nodes = array();

    /**
     * All registered node results.
     *
     * @var array
     */
    protected $nodeResults = array();

    /**
     * The agi client in use.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * Node name.
     *
     * @var string
     */
    private $name = 'X';

    /**
     * Runs a node and process the result.
     *
     * @param string $name Node to run
     */
    public function jumpTo($name)
    {
        if (!isset($this->nodes[$name])) {
            throw new NodeException(sprintf('Unknown node: %s', $name));
        }

        // cant make this recursive because php does not support tail
        // recursion optimization.
        while ($name !== false) {
            $node = $this->nodes[$name];
            $node->run();

            $name = $this->processNodeResult($node);
        }
    }

    /**
     * Process the result of the given node. Returns false if no other nodes
     * should be run, or a string with the next node name.
     *
     * @param Node $node Node that was run
     *
     * @return string
     */
    protected function processNodeResult(Node $node)
    {
        $result = null;
        $name = $node->getName();
        if (isset($this->nodeResults[$name])) {
            foreach ($this->nodeResults[$name] as $resultInfo) {
                if ($resultInfo->appliesTo($node)) {
                    if ($resultInfo->isActionHangup()) {
                        // hanging up after $name
                        $this->client->hangup();
                    } elseif ($resultInfo->isActionJumpTo()) {
                        $data = $resultInfo->getActionData();
                        if (isset($data['nodeEval'])) {
                            $callback = $data['nodeEval'];
                            $nodeName = $callback($node);
                        } else {
                            $nodeName = $data['nodeName'];
                        }

                        // jumping from $name to $nodeName
                        $result = $nodeName;
                    } elseif ($resultInfo->isActionExecute()) {
                        // executing callback after $name
                        $data = $resultInfo->getActionData();
                        $callback = $data['callback'];
                        $callback($node);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Registers a new node result to be taken into account when the given node
     * is ran.
     *
     * @param string $name
     *
     * @return NodeActionCommand
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
     * @return Node
     */
    public function register($name)
    {
        $node = $this->client->createNode($name);
        $this->nodes[$name] = $node;

        return $node;
    }

    /**
     * Gives a name for this node.
     *
     * @param string $name
     *
     * @return Node
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets the agi client to use by this node.
     *
     * @param ClientInterface $client AGI client
     *
     * @return NodeController
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }
}
