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

/**
 * A node action command. Basically a DTO to declare what to do when a given
 * node finished execution.
 */
class NodeActionCommand
{
    protected $result = 0;
    protected $action = 0;
    protected $data = array();
    protected $nodeName = null;

    const NODE_RESULT_CANCEL = 1;
    const NODE_RESULT_COMPLETE = 2;
    const NODE_RESULT_MAX_ATTEMPTS_REACHED = 3;

    const NODE_ACTION_HANGUP = 1;
    const NODE_ACTION_JUMP_TO = 2;
    const NODE_ACTION_EXECUTE = 3;

    /**
     * Sets the controlled node.
     *
     * @param string $name The name of the controlled node
     *
     * @return NodeActionCommand
     */
    public function whenNode($name)
    {
        $this->nodeName = $name;

        return $this;
    }

    /**
     * Do the configured action when the node has been cancelled.
     *
     * @return NodeActionCommand
     */
    public function onCancel()
    {
        $this->result = self::NODE_RESULT_CANCEL;

        return $this;
    }

    /**
     * Do the configured action when the node has completed successfully.
     *
     * @return NodeActionCommand
     */
    public function onComplete()
    {
        $this->result = self::NODE_RESULT_COMPLETE;

        return $this;
    }

    /**
     * Do the configured action when the node has completed successfully with
     * this specific input from the user. Very useful for menues.
     *
     * @param string $input The expected input from the user
     *
     * @return NodeActionCommand
     */
    public function withInput($input)
    {
        $this->data['input'] = $input;

        return $this;
    }

    /**
     * Do the configured action when the node finished without a valid input
     * from the user.
     *
     * @return NodeActionCommand
     */
    public function onMaxAttemptsReached()
    {
        $this->result = self::NODE_RESULT_MAX_ATTEMPTS_REACHED;

        return $this;
    }

    /**
     * As an action, jump to the given node (name).
     *
     * @param string $name The node name where to jump to
     *
     * @return NodeActionCommand
     */
    public function jumpTo($name)
    {
        $this->action = self::NODE_ACTION_JUMP_TO;
        $this->data['nodeName'] = $name;

        return $this;
    }

    /**
     * As an action, evaluate the given callback and jump to the node (name)
     * returned by it.
     *
     * @param \Closure $callback A string MUST be returned that is the name
     *                           of the node to jump to
     *
     * @return NodeActionCommand
     */
    public function jumpAfterEval(\Closure $callback)
    {
        $this->action = self::NODE_ACTION_JUMP_TO;
        $this->data['nodeEval'] = $callback;

        return $this;
    }

    /**
     * As an action, hangup the call with the given cause.
     *
     * @param integer $cause
     *
     * @return NodeActionCommand
     */
    public function hangup($cause)
    {
        $this->action = self::NODE_ACTION_HANGUP;
        $this->data['hangupCause'] = $cause;

        return $this;
    }

    /**
     * As an action, execute the given callback.
     *
     * @param \Closure $callback
     *
     * @return NodeActionCommand
     */
    public function execute(\Closure $callback)
    {
        $this->action = self::NODE_ACTION_EXECUTE;
        $this->data['callback'] = $callback;

        return $this;
    }

    /**
     * Returns the action information.
     *
     * @return array
     */
    public function getActionData()
    {
        return $this->data;
    }

    /**
     * True if the given node (already executed) matches with the specs defined
     * in this action command.
     *
     * @param Node $node
     *
     * @return Boolean
     */
    public function appliesTo(Node $node)
    {
        if (
            $node->wasCancelled()
            && $this->result == self::NODE_RESULT_CANCEL
        ) {
            return true;
        } elseif (
            $node->isComplete()
            && $this->result == self::NODE_RESULT_COMPLETE
            && (!isset($this->data['input']) || $this->data['input'] == $node->getInput())
        ) {
            return true;
        } elseif (
            $node->maxInputsReached()
            && $this->result == self::NODE_RESULT_MAX_ATTEMPTS_REACHED
        ) {
            return true;
        }

        return false;
    }

    /**
     * True if a callback should be executed as an action.
     *
     * @return Boolean
     */
    public function isActionExecute()
    {
        return $this->action == self::NODE_ACTION_EXECUTE;
    }

    /**
     * True if hangup should be done as an action.
     *
     * @return Boolean
     */
    public function isActionHangup()
    {
        return $this->action == self::NODE_ACTION_HANGUP;
    }

    /**
     * True if we have to jump to another node as an action.
     *
     * @return Boolean
     */
    public function isActionJumpTo()
    {
        return $this->action == self::NODE_ACTION_JUMP_TO;
    }
}
