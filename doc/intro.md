Introduction
============

PAGI is a PHP client for AGI: [Asterisk Gateway Interface](http://www.asteriskdocs.org/en/3rd_Edition/asterisk-book-html-chunk/AGI.html). AGI is a very simple protocol, and it has been implemented in a wide variety of languages, allowing to quickly create telephony applications, like [IVR](http://en.wikipedia.org/wiki/Interactive_voice_response)'s, voicemails, prepaid telephony systems, etc.

Testing IVR applications
========================

A mocked PAGI client is included to easily test your IVR applications. See an [example](https://github.com/marcelog/PAGI/tree/master/doc/examples/mock) of how to use it.

Nodes
=====

For a tutorial about nodes, see [this article](http://marcelog.github.com/articles/pagi_node_call_flow_easy_telephony_application_for_asterisk_php.html).

Simple Call Flow Nodes are available (see an [example](https://github.com/marcelog/PAGI/tree/master/doc/examples/node/app.php)). Using
nodes will let you simplify how you build and test your IVR applications. Nodes are an abstraction layer above
the PAGI client, and support:

- Prompts mixing sound files, playing numbers/digits/datetime's.
- Cancel and End Of Input digits.
- Validator callbacks for inputs, can optionally specify 1 or more sound files to play when the validation fails.
- Callbacks for invalid and valid inputs.
- Optional sound when no input.
- Maximum valid input attempts.
- Optional sound when maximum attempts has been reached.
- Expecting at least/at most/exactly N digits per input.
- Timeout between digits in more-than-1 digit inputs.
- Timeout per input attempt.
- Retry Attempts for valid inputs.
- And much more!

The NodeController will let you control the call flow of your application, by registering nodes and actions based
on node results. Thus, you can jump from one node to the other on cancel or complete inputs, hangup the call,
execute a callback, etc.

An article about the node controller is available [here](http://marcelog.github.com/articles/making_your_ivr_nodes_call_flow_with_pagi_and_php_asterisk.html).

AutoDial
========

CallFiles are supported. You can also schedule a call in the future.

Fax
===

Sending and receiving faxes is supported using spandsp (applications SendFax and ReceiveFax).

Available Facades
=================

- PAGI\CDR\CDRFacade: Provided to access cdr variables.
- PAGI\ChannelVariables\ChannelVariablesFacade: Provided to access channel variables and asterisk environment variables.
- PAGI\CallerId\CallerIdFacade: Provided to access caller id variables.
- PAGI\Client\Result\Result: Provided to wrap up the result for AGI commands.
- PAGI\CallSpool\CallFile: Call file facade.
- PAGI\CallSpool\CallSpool: Call spool facade.

Results
=======

For every operation, a Result is provided. Some operations decorate this
Result to add functionality, like PlayResult, ReadResult, etc. For example,
a stream file will return a PlayResult, which decorates a ReadResult which
in turn, decorated a Result.

- PAGI\Client\Result\DialResult
- PAGI\Client\Result\ExecResult
- PAGI\Client\Result\ReadResult
- PAGI\Client\Result\PlayResult
- PAGI\Client\Result\FaxResult
