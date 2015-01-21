[![Build Status](https://travis-ci.org/marcelog/PAGI.svg)](https://travis-ci.org/marcelog/PAGI)

Introduction
============
This framework is intended to simply making ivr applications using Asterisk's
AGI, providing a nice level of abstraction over what an IVR should look like
from a developers' perspective.

Resources:

 * [Complete PAGI/PAMI talk for the PHP Conference Argentina 2013](http://www.slideshare.net/mgornstein/phpconf-2013). Check the slide notes for the complete text :)
 * [Main Site](http://marcelog.github.com/PAGI)
 * [In-depth tutorial](http://marcelog.github.com/articles/pagi_tutorial_create_voip_telephony_application_for_asterisk_with_agi_and_php.html)
 * [An example IVR application that includes unit tests is available here](https://github.com/marcelog/Pagi-App-And-Test-Example)
 * [API](http://ci.marcelog.name:8080/job/PAGI/javadoc/)
 * [CI (Jenkins)](http://ci.marcelog.name/ provides API, metrics, and distributables).
 * [Packagist Home](http://packagist.org/packages/marcelog/pagi)
 * [Professional Telephony Applications at hand](http://sdjournal.org/a-practical-introduction-to-functional-programming-with-php-sdj-issue-released/) The march edition of [Software Developer Journal](http://sdjournal.org/) features a complete article about writing telephony applications with PAMI and PAGI.

Contact me
----------
If you have any questions, issues, feature requests, or just want to report
your "success story", or maybe even say hi, please send an email to marcelog@gmail.com

Included Example
----------------
Please see **docs/examples** for all the included examples.

You can start by *docs/examples/quickstart* for a very basic example. You'll need something like this in your dialplan:

    [default]
    exten => 1,1,AGI(/path/to/PAGI/docs/examples/quickstart/run.sh,a,b,c,d)
    exten => 1,n,Hangup

Available via Composer
----------------------
Just add the package "marcelog/pagi":

    {
        "require": {
            "marcelog/pagi": "dev-master"
        },
        "repositories": [
        {
          "type": "pear",
          "url": "http://pear.apache.org/log4php/"
        }]
    }

Packagist URL: (http://packagist.org/packages/marcelog/pagi)

Available via PEAR
------------------
You can now easily install PAGI by issuing:

    pear channel-discover pear.marcelog.name
    pear install marcelog/PAGI

or

    pear install marcelog/PAGI-X.Y.Z
just replace X.Y.Z by the release version you'd like to install :)

See the [pear channel](http://pear.marcelog.name/)

Available as PHAR
-----------------
Just go to the [Jenkins server](http://ci.marcelog.name) and grab the latest
phar distribution from the PAGI job.

Testing IVR applications
========================
A mocked pagi client is included to easily test your ivr applications. See
**docs/examples/mock** to see an example of how to use it.

Nodes
=====
For a tutorial about nodes, see [this article](http://marcelog.github.com/articles/pagi_node_call_flow_easy_telephony_application_for_asterisk_php.html)

Simple Call Flow Nodes are available (see **docs/examples/node/example.php**). Using
nodes will let you simplify how you build and test your ivr applications. Nodes
are an abstraction layer above the pagi client, and support:

 * Prompts mixing sound files, playing numbers/digits/datetime's.
 * Cancel and End Of Input digits.
 * Validator callbacks for inputs, can optionally specify 1 or more sound files
 to play when the validation fails.
 * Callbacks for invalid and valid inputs.
 * Optional sound when no input.
 * Maximum valid input attempts.
 * Optional sound when maximum attempts has been reached.
 * Expecting at least/at most/exactly N digits per input.
 * Timeout between digits in more-than-1 digit inputs.
 * Timeout per input attempt.
 * Retry Attempts for valid inputs.
 * And much more!

The NodeController will let you control the call flow of your application, by
registering nodes and actions based on node results. Thus, you can jump from
one node to the other on cancel or complete inputs, hangup the call, execute a
callback, etc. For an example, see docs/examples/nodecontroller/example.php

An article about the node controller is available [here](http://marcelog.github.com/articles/making_your_ivr_nodes_call_flow_with_pagi_and_php_asterisk.html)

AutoDial
========
CallFiles are supported. You can also schedule a call in the future.

Fax
===
Sending and receiving faxes is supported using spandsp (applications SendFax
and ReceiveFax).

Available Facades
=================
 * PAGI\Client\CDR: Provided to access cdr variables.
 * PAGI\Client\ChannelVariables: Provided to access channel variables and asterisk
environment variables.
 * PAGI\Client\CallerID: Provided to access caller id variables.
 * PAGI\Client\Result: Provided to wrap up the result for agi commands.
 * PAGI\CallSpool\CallFile: Call file facade.
 * PAGI\CallSpool\CallSpool: Call spool facade.
 * PAGI\Logger\Asterisk: Provides access to asterisk logger (see logger.conf in
your asterisk installation).

Results
=======
For every operation, a Result is provided. Some operations decorate this
Result to add functionality, like PlayResult, ReadResult, etc. For example,
a stream file will return a PlayResult, which decorates a ReadResult which 
in turn, decorated a Result.

  * PAGI\Client\DialResult
  * PAGI\Client\ExecResult
  * PAGI\Client\ReadResult
  * PAGI\Client\PlayResult
  * PAGI\Client\FaxResult

Debugging, logging
==================
You need [log4php](http://logging.apache.org/log4php/). Just make sure you
copy it to the include_path and PAGI will pick it up from there (the 
directory *src/main/php* is the one that needs to be in the include_path).

Developers
==========
* build.xml is a phing build file, not ant.
* It's very possible that you may need to edit build.properties.
* Available main targets: all, build, test, report.
* Tools run: phpdoc, phploc, phpcs, phpmd, phpcpd, phpdepend, phpunit.
* Setup your installation by editing pear and php paths in build.properties
* Run phing install-dependencies this will install pear and everything needed
to run phing tests and metrics.
* Copy resources/php.ini.example to resources/php.ini and edit it.
* Run phing all

LICENSE
=======
Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

