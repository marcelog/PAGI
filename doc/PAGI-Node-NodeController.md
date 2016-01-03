PAGI\Node\NodeController
===============

A node controller, used to execute a series of nodes while evaluating
their output.




* Class name: NodeController
* Namespace: PAGI\Node





Properties
----------


### $nodes

    protected array<mixed,\PAGI\Node\Node> $nodes = array()

All registered nodes.



* Visibility: **protected**


### $nodeResults

    protected array<mixed,\PAGI\Node\NodeActionCommand> $nodeResults = array()

All registered node results.



* Visibility: **protected**


### $client

    protected \PAGI\Client\IClient $client

The PAGI client in use.



* Visibility: **protected**


### $logger

    protected \PAGI\Logger\Asterisk\IAsteriskLogger $logger

Asterisk logger instance to use.



* Visibility: **protected**


### $name

    private string $name = 'X'

Node name.



* Visibility: **private**


Methods
-------


### jumpTo

    void PAGI\Node\NodeController::jumpTo(string $name)

Runs a node and process the result.



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;Node to run.&lt;/p&gt;



### processNodeResult

    string|false PAGI\Node\NodeController::processNodeResult(\PAGI\Node\Node $node)

Process the result of the given node. Returns false if no other nodes
should be run, or a string with the next node name.



* Visibility: **protected**


#### Arguments
* $node **[PAGI\Node\Node](PAGI-Node-Node.md)** - &lt;p&gt;Node that was run.&lt;/p&gt;



### registerResult

    \PAGI\Node\NodeActionCommand PAGI\Node\NodeController::registerResult(string $name)

Registers a new node result to be taken into account when the given node
is ran.



* Visibility: **public**


#### Arguments
* $name **string**



### register

    \PAGI\Node\Node PAGI\Node\NodeController::register(string $name)

Registers a new node in the application. Returns the created node.



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;The node to be registered&lt;/p&gt;



### setName

    \PAGI\Node\Node PAGI\Node\NodeController::setName(string $name)

Gives a name for this node.



* Visibility: **public**


#### Arguments
* $name **string**



### setAgiClient

    \PAGI\Node\NodeController PAGI\Node\NodeController::setAgiClient(\PAGI\Client\IClient $client)

Sets the pagi client to use by this node.



* Visibility: **public**


#### Arguments
* $client **[PAGI\Client\IClient](PAGI-Client-IClient.md)**



### logDebug

    void PAGI\Node\NodeController::logDebug(string $msg)

Used internally to log debug messages



* Visibility: **protected**


#### Arguments
* $msg **string**


