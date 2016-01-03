PAGI\Node\NodeActionCommand
===============

A node action command. Basically a DTO to declare what to do when a given
node finished execution.




* Class name: NodeActionCommand
* Namespace: PAGI\Node



Constants
----------


### NODE_RESULT_CANCEL

    const NODE_RESULT_CANCEL = 1





### NODE_RESULT_COMPLETE

    const NODE_RESULT_COMPLETE = 2





### NODE_RESULT_MAX_ATTEMPTS_REACHED

    const NODE_RESULT_MAX_ATTEMPTS_REACHED = 3





### NODE_ACTION_HANGUP

    const NODE_ACTION_HANGUP = 1





### NODE_ACTION_JUMP_TO

    const NODE_ACTION_JUMP_TO = 2





### NODE_ACTION_EXECUTE

    const NODE_ACTION_EXECUTE = 3





Properties
----------


### $result

    protected mixed $result





* Visibility: **protected**


### $action

    protected mixed $action





* Visibility: **protected**


### $data

    protected mixed $data = array()





* Visibility: **protected**


### $nodeName

    protected mixed $nodeName = null





* Visibility: **protected**


Methods
-------


### whenNode

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::whenNode(string $name)

Sets the controlled node.



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;The name of the controlled node.&lt;/p&gt;



### onCancel

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::onCancel()

Do the configured action when the node has been cancelled.



* Visibility: **public**




### onComplete

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::onComplete()

Do the configured action when the node has completed successfully.



* Visibility: **public**




### withInput

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::withInput(string $input)

Do the configured action when the node has completed successfully with
this specific input from the user. Very useful for menues.



* Visibility: **public**


#### Arguments
* $input **string** - &lt;p&gt;The expected input from the user.&lt;/p&gt;



### onMaxAttemptsReached

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::onMaxAttemptsReached()

Do the configured action when the node finished without a valid input
from the user.



* Visibility: **public**




### jumpTo

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::jumpTo(string $name)

As an action, jump to the given node (name).



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;The node name where to jump to.&lt;/p&gt;



### jumpAfterEval

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::jumpAfterEval(\Closure $callback)

As an action, evaluate the given callback and jump to the node (name)
returned by it.



* Visibility: **public**


#### Arguments
* $callback **Closure** - &lt;p&gt;A string MUST be returned that is the name
of the node to jump to.&lt;/p&gt;



### hangup

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::hangup(integer $cause)

As an action, hangup the call with the given cause.



* Visibility: **public**


#### Arguments
* $cause **integer**



### execute

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeActionCommand::execute(\Closure $callback)

As an action, execute the given callback.



* Visibility: **public**


#### Arguments
* $callback **Closure**



### getActionData

    array PAGI\Node\NodeActionCommand::getActionData()

Returns the action information.



* Visibility: **public**




### appliesTo

    boolean PAGI\Node\NodeActionCommand::appliesTo(\PAGI\Node\Node $node)

True if the given node (already executed) matches with the specs defined
in this action command.



* Visibility: **public**


#### Arguments
* $node **[PAGI\Node\Node](PAGI-Node-Node.md)**



### isActionExecute

    boolean PAGI\Node\NodeActionCommand::isActionExecute()

True if a callback should be executed as an action.



* Visibility: **public**




### isActionHangup

    boolean PAGI\Node\NodeActionCommand::isActionHangup()

True if hangup should be done as an action.



* Visibility: **public**




### isActionJumpTo

    boolean PAGI\Node\NodeActionCommand::isActionJumpTo()

True if we have to jump to another node as an action.



* Visibility: **public**



