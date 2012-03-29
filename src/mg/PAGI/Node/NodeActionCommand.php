<?php
namespace PAGI\Node;

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

    public function whenNode($name)
    {
        $this->nodeName = $name;
        return $this;
    }

    public function onCancel()
    {
        $this->result = self::NODE_RESULT_CANCEL;
        return $this;
    }
    public function onComplete()
    {
        $this->result = self::NODE_RESULT_COMPLETE;
        return $this;
    }
    public function withInput($input)
    {
        $this->data['input'] = $input;
        return $this;
    }
    public function onMaxAttemptsReached()
    {
        $this->result = self::NODE_RESULT_MAX_ATTEMPTS_REACHED;
        return $this;
    }

    public function jumpTo($name)
    {
        $this->action = self::NODE_ACTION_JUMP_TO;
        $this->data['nodeName'] = $name;
        return $this;
    }

    public function jumpAfterEval(\Closure $callback)
    {
        $this->action = self::NODE_ACTION_JUMP_TO;
        $this->data['nodeEval'] = $callback;
        return $this;
    }

    public function hangup($cause)
    {
        $this->action = self::NODE_ACTION_HANGUP;
        $this->data['hangupCause'] = $cause;
        return $this;
    }

    public function execute(\Closure $callback)
    {
        $this->action = self::NODE_ACTION_EXECUTE;
        $this->data['callback'] = $callback;
        return $this;
    }

    public function getActionData()
    {
        return $this->data;
    }

    public function appliesTo(Node $node)
    {
        if (
            $node->wasCancelled()
            && $this->result == self::NODE_RESULT_CANCEL
        ) {
            return true;
        } else if (
            $node->isComplete()
            && $this->result == self::NODE_RESULT_COMPLETE
            && (!isset($this->data['input'])
                || $this->data['input'] == $node->getInput()
                )
        ) {
            return true;
        } else if (
            $node->maxInputsReached()
            && $this->result == self::NODE_RESULT_MAX_ATTEMPTS_REACHED
        ) {
            return true;
        }
        return false;
    }

    public function isActionExecute()
    {
        return $this->action == self::NODE_ACTION_EXECUTE;
    }

    public function isActionHangup()
    {
        return $this->action == self::NODE_ACTION_HANGUP;
    }

    public function isActionJumpTo()
    {
        return $this->action == self::NODE_ACTION_JUMP_TO;
    }
}
