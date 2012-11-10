Usage
=====

This chapter describes how to use PAGI.


Setup asterisk dial-plan
-----------------------

First of all, you've got to setup asterisk so it will run your AGI application in a given extension. For example,
we can do this in the [extensions.conf](http://www.voip-info.org/wiki/view/Asterisk+config+extensions.conf) file:

```
exten => _X.,1,AGI(/tmp/app.php)
exten => _X.,n,Hangup
```

The _**X**. is a [dialplan pattern](http://www.voip-info.org/wiki/view/Asterisk+Dialplan+Patterns), it will match any number dialed as long as it is 1 digit long. You can of course go
ahead and write your own pattern or use an exact number, like "111" or "5555555".

So the first line uses the dial-plan [AGI command](http://www.voip-info.org/wiki/view/Asterisk+cmd+AGI) to invoke your application. This tells asterisk to [`fork()`](http://pubs.opengroup.org/onlinepubs/009604599/functions/fork.html) a new process
and [`exec()`](http://pubs.opengroup.org/onlinepubs/009604599/functions/exec.html) the given path (in this case /tmp/app.php, but it can be anything that is executable, we'll see that in a bit).

The second line is just a safe bet, a [Hangup command](http://www.voip-info.org/wiki/view/Asterisk+cmd+Hangup), just in case your app goes a little funny on the call and does not
terminate it in an appropriate way.

The PAGI Client
---------------

The PAGI client is the central player here, it will handle all the communication with asterisk during the call.
Actually, as you can see, this is just an interface. An abstract implementation exists (the AbstractClient)
that implements the AGI commands declared in the ClientInterface, but it leaves the implementation details
for managing the I/O to its subclasses.

Specifically, this lets you use the standard client implementation, or something like AMI's AsyncClient,
suitable for [Async AGI](http://www.moythreads.com/wordpress/2007/12/24/asterisk-asynchronous-agi/) applications.

In this case, we're going to use the standard PAGI client implementation.

Getting an instance of the client
---------------------------------

```php
<?php

use Asterisk\Client\Client;

$client = Client::getInstance();
```

**NOTE:** The client accepts an array with options. The available options are:

- stdin: Optional. If set, should contain an already open stream from where the client will read data
(useful to make it interact with fastagi servers or even text files to mock stuff when testing). If not
set, stdin will be used by the client.

- stdout: Same as stdin but for the output of the client.

**NOTE:** Since AGI establishes the use of [stdin](http://en.wikipedia.org/wiki/Standard_streams#Standard_input_.28stdin.29) and [stdout](http://en.wikipedia.org/wiki/Standard_streams#Standard_output_.28stdout.29) for communication, you cant write anything that
outputs to console directly (like `echo`'s, or `var_dump`'s).

Checkpoint #1: A basic application
==================================

```php
<?php

use Asterisk\Client\Client;

$client = Client::getInstance();

$client->answer();
$client->sayDigits(123);
$client->hangup();
```

Now dial into your asterisk, you should listen to the numbers "one", "two", and "three". From now on, I'll
mention some if the many things you can do through the PAGI client, you should refer to the ClientInterface
to see all the available stuff!

The decorated results
---------------------

Sometimes you want the user to input 1 digit, or many digits, or let him/her interrupt the messages played,
or do something if no input is received, or any kind of logic associated with playing and reading simultaneously.
Every result from an AGI command that PAGI issues, is returned as a ResultInterface. This is then implemented in
ResultDecorator, effectively implementing the [decorator pattern](http://en.wikipedia.org/wiki/Decorator_pattern) to return the result of the operation. This
is so, because sometimes you only want to play a file, sometimes you just want to read digits, and sometimes
you want to play AND read input from the user, and you might need to check the result of one or all the operations.
See the API documentation for all the results available, in the namespace PAGI\Client\Result.
You should check the api documentation for the method you are using to see what kind of result is available
(ExecResult, RecordResult, FaxResult, PlayResult, etc). See below.

Playing a sound file
--------------------

```php
<?php

$result = $client->streamFile($aSoundFile, $escapeDigits);
```

Where:

- `$aSoundFile`: A sound file to play, like 'welcome', or 'silence/1', etc.
- `$escapeDigits`: The digits that can be used to skip the sound file, like "#" or "01234567890*#".

`$result` will be a PlayResult that you can use to get information about what happened while the file
was playing.

```php
<?php

if ($result->isTimeout()) {
    // The user did not interrupt the play
} else {
    // The user interrupted the play
    $digits = $result->getDigits(); // Get what the user pressed
}
```

Reading input from the user
---------------------------

To read input from the user, you have a couple of options:

```php
<?php

// Read a single digit, play a sound file as a prompt.
$result = $client->getOption(
    $aSoundFile, $escapeDigits, $maxInputTime
);

// Read a single digit, no sound file played.
$result = $client->waitDigit($maxInputTime);

// Get at least 1 digit, playing a sound file as a prompt.
$result = $client->getData(
    $aSoundFile, $maxInputTime, $maxDigitsToRead
);
```

Where:

- `$maxInputTime`: The maximum amount of time to wait for the user input in milliseconds.
- `$maxDigitsToRead`: The maximum number of digits a user can input for this reading.

In the case of waitDigit(), the result is a DigitReadResult, and the others return a PlayResult.

Playing indication tones
------------------------

 You can also play some standard tones, these might need some tweaking in your [indications.conf](http://www.voip-info.org/wiki/view/Asterisk+config+indications.conf) file:

```php
<?php

$client->playDialTone();
$client->playCongestionTone($seconds);
$client->playBusyTone($seconds);
```

And you can also send indications at the signaling level, without playing any audio:

```php
<?php

$client->indicateProgress();
$client->indicateBusy();
$client->indicateCongestion();
```

Playing Music On Hold
---------------------

Putting music on hold is also quite easy. You might need to configure your [moh.conf](http://www.voip-info.org/wiki/view/Asterisk+config+musiconhold.conf) file:

```php
<?php

$client->setMusic(true, 'myMOHClass');
$client->setMusic(false);
```

Logging through asterisk
------------------------

In case you want to log stuff through the asterisk logger (so your messages get to the asterisk console
or general asterisk log files), you can use the AsteriskLoggerInterface:

```php
<?php

$logger = $client->getAsteriskLogger();

$logger->dtmf('A DTMF priority message');
$logger->verbose('A VERBOSE priority message');
$logger->debug('A DEBUG priority message');
$logger->notice('A NOTICE priority message');
$logger->error('An ERROR priority message');
$logger->warn('A WARNING priority message');
```


Manipulating the channel variables
----------------------------------

When AGI handshake starts, the server (asterisk) sends a couple of [channel variables](https://wiki.asterisk.org/wiki/display/AST/Asterisk+Standard+Channel+Variables). The PAGI
client offers the ChannelVariablesInterface to access them:

```php
<?php

$channelVariables = $client->getChannelVariables();

$logger->debug($channelVariables->getCallerId());
$logger->debug($channelVariables->getDNIS());
```

To set a variable, you would do:

```php
<?php

$client->setVariable('myVariable', 'myValue');

$logger->debug($client->getVariable('myVariable'));
```

The ChannelVariablesInterface also provides access to some important environment variables. For example, to get
the directory where spooled call files should go:

```php
<?php

$spoolDir = $channelVariables->getDirectorySpool();
```

Manipulating the CDR (Call Detail Record)
-----------------------------------------

PAGI offers the CDRInterface to interact with the CDR's, by setting custom values and retrieving the ones
set by asterisk itself:

```php
<?php

$cdr = $client->getCDR();
$cdr->setUserfield('my own content here');
$cdr->setAccountCode('blah');
$cdr->setCustom('myOwnField', 'withMyOwnValue');

$logger->debug($cdr->getAnswerLength());
```

Working with the Caller ID's
----------------------------

In order to get and set caller id values, you can access the ICallerId interface:

```php
<?php

$clid = $client->getCallerId();

$logger->debug($clid->getNumber());

$clid->setNumber('123123');
```

In this case, the next [dial command](http://www.voip-info.org/wiki/view/Asterisk+cmd+Dial) will carry the caller id set.

To set the caller id presentation mode:

```php
<?php

$clid = $client->getCallerId();
$clid->setCallerPres('allowed_not_screened');
```

For the complete list of caller id presentation modes, see: http://www.voip-info.org/wiki/view/Asterisk+func+CALLERPRES.

Manipulating SIP headers
------------------------

Before issuing a dial(), you may need to set some sip headers (to set privacy settings, or whatever). Here's
how you can do it with the PAGI client:

```php
<?php

$client->sipHeaderAdd('Privacy', 'Id');
$client->sipHeaderAdd('P-Asserted-Identity', 'Anonymous');
```

To delete a header:

```php
<?php

$client->sipHeaderRemove('Privacy');
$client->sipHeaderRemove('P-Asserted-Identity');
```

Spooling calls through call files
---------------------------------

Asterisk lets you use [call files](http://www.voip-info.org/wiki/view/Asterisk+auto-dial+out) to generate calls automatically, you can access this feature via the CallSpoolInterface:

```php
<?php

use PAGI\DialDescriptor\SIPDialDescriptor;
use PAGI\CallSpool\CallFile;
use PAGI\CallSpool\CallSpool;

$dialDescriptor = new SIPDialDescriptor('myDevice', 'myProvider');

$callFile = new CallFile($dialDescriptor);
$callFile->setCallerId('123');
$callFile->setContext('campaignContext');
$callFile->setExtension('555');
$callFile->setPriority(1);

$spool = CallSpool::getInstance(array(
    'tmpDir' => '/tmp/temporaryDirForSpool',
    'spoolDir' => '/var/lib/asterisk/spool/outgoing'
));
```

The DialDescriptor is an abstraction over dial strings, so you don't have to code them yourself. Currently,
PAGI supports SIPDialDescriptor and DAHDIDialDescriptor.

This example will then issue a dial to **SIP/myDevice@myProvider** with the caller id "123". When the call is
answered, it will go to context "campaignContext", in the priority 1 of the extension 555. There are many
options you can use in the CallFile, like custom variables, timeouts, etc.

The array passed to the CallSpool::getInstance() method is necessary so the call file can be created in a
temporary directory and then moved to the real asterisk spool directory, so asterisk will pick it up when it's
completely written to disk.

Dialing
-------

If you want to [Dial](http://www.voip-info.org/wiki/view/Asterisk+cmd+Dial) from an AGI application:

```php
<?php

$result = dial('DAHDI/g1/5555555', array(60, 'rh'));

if ($result->isAnswer()) {
    $logger->debug($result->getAnsweredTime());
}
```

The result is a DialResult

The PAGI Application
--------------------

The PAGI client can also be used inside a PAGI Application. That is, your own IVR application can be
itself a PAGIApplication, by extending it. This will provide a number of features:

- An [error handler](http://us.php.net/set_error_handler) is automatically registered, and will invoke PAGIApplication::errorHandler() method.
- A [signal handler](http://us.php.net/pcntl_signal) is automatically registered for the signals SIGINT, SIGQUIT, SIGTERM, SIGHUP, SIGUSR1,
SIGUSR2, SIGCHLD, SIGALRM, and will invoke PAGIApplication::signalHandler() method.
- A [shutdown handler](http://us.php.net/manual/en/function.register-shutdown-function.php) is automatically registered, and will invoke PAGIApplication::shutdown()
- An init method, PAGIApplication::init()

Checkpoint #2: A complete PAGI Application Skeleton
===================================================

```bash
#!/usr/bin/php
<?php

use PAGI\Application\Application;
use PAGI\Client\Client;

class MyApplication extends Application
{
    protected $logger;

    public function init()
    {
        $this->logger = $this->getClient()->getAsteriskLogger();

        $this->logger->notice('Init');
    }

    public function run()
    {
        $this->logger->info('Run');
    }

    public function signalHandler($signo)
    {
        $this->logger->info(sprintf('Got signal: %s', $signo));
    }

    public function errorHandler($type, $message, $file, $line)
    {
        $this->logger->error(sprintf('%s at  %s: $s', $message, $file, $line));
    }

    public function shutdown()
    {
        $this->logger->notice('Shutdown');
    }
}

$app = new MyApplication($Client::getInstance());
$app->init();
$app->run();
```
