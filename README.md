[![License](https://poser.pugx.org/marcelog/PAGI/license)](https://packagist.org/packages/marcelog/PAGI)
[![Latest Stable Version](https://poser.pugx.org/marcelog/PAGI/v/stable)](https://packagist.org/packages/marcelog/PAGI)
[![Documentation Status](https://readthedocs.org/projects/pami/badge/?version=latest)](http://pami.readthedocs.org/en/latest/?badge=latest)

[![Build Status](https://travis-ci.org/marcelog/PAGI.svg)](https://travis-ci.org/marcelog/PAGI)
[![Coverage Status](https://coveralls.io/repos/marcelog/PAGI/badge.svg?branch=master&service=github)](https://coveralls.io/github/marcelog/PAGI?branch=master)
[![Code Climate](https://codeclimate.com/github/marcelog/PAGI/badges/gpa.svg)](https://codeclimate.com/github/marcelog/PAGI)
[![Issue Count](https://codeclimate.com/github/marcelog/PAGI/badges/issue_count.svg)](https://codeclimate.com/github/marcelog/PAGI)

# Introduction

This framework is intended to simply making ivr applications using Asterisk's
AGI, providing a nice level of abstraction over what an IVR should look like
from a developers' perspective.

Resources:

 * [Main Site](http://marcelog.github.com/PAGI)
 * [API](https://github.com/marcelog/PAGI/blob/master/doc/ApiIndex.md)
 * [Complete PAGI/PAMI talk for the PHP Conference Argentina 2013](http://www.slideshare.net/mgornstein/phpconf-2013). Check the slide notes for the complete text :)
 * [In-depth tutorial](http://marcelog.github.com/articles/pagi_tutorial_create_voip_telephony_application_for_asterisk_with_agi_and_php.html)
 * [An example IVR application that includes unit tests is available here](https://github.com/marcelog/Pagi-App-And-Test-Example)
 * [Professional Telephony Applications at hand](http://sdjournal.org/a-practical-introduction-to-functional-programming-with-php-sdj-issue-released/) The march edition of [Software Developer Journal](http://sdjournal.org/) features a complete article about writing telephony applications with PAMI and PAGI.

# Installing
Add this library to your [Composer](https://packagist.org/) configuration. In
composer.json:
```json
  "require": {
    "marcelog/pagi": "2.*"
  }
```

# Using it

First, make sure you include the [autoloader shipped with composer](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require __DIR__ . '/vendor/autoload.php';
```

# Quickstart

You can start by *docs/examples/quickstart* for a very basic example. You'll need something like this in your dialplan:

    [default]
    exten => 1,1,AGI(/path/to/PAGI/docs/examples/quickstart/run.sh,a,b,c,d)
    exten => 1,n,Hangup

# Testing IVR applications

A mocked pagi client is included to easily test your ivr applications. See
**docs/examples/mock** to see an example of how to use it.

# Features

## Nodes

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

## AutoDial

CallFiles are supported. You can also schedule a call in the future.

## Fax

Sending and receiving faxes is supported using spandsp (applications SendFax
and ReceiveFax).

## Available Facades

 * PAGI\Client\CDR: Provided to access cdr variables.
 * PAGI\Client\ChannelVariables: Provided to access channel variables and asterisk
environment variables.
 * PAGI\Client\CallerID: Provided to access caller id variables.
 * PAGI\Client\Result: Provided to wrap up the result for agi commands.
 * PAGI\CallSpool\CallFile: Call file facade.
 * PAGI\CallSpool\CallSpool: Call spool facade.
 * PAGI\Logger\Asterisk: Provides access to asterisk logger (see logger.conf in
your asterisk installation).

## Results

For every operation, a Result is provided. Some operations decorate this
Result to add functionality, like PlayResult, ReadResult, etc. For example,
a stream file will return a PlayResult, which decorates a ReadResult which
in turn, decorated a Result.

  * PAGI\Client\DialResult
  * PAGI\Client\ExecResult
  * PAGI\Client\ReadResult
  * PAGI\Client\PlayResult
  * PAGI\Client\FaxResult

## Debugging, logging

You can optionally set a [PSR-3](http://www.php-fig.org/psr/psr-3/) compatible logger:
```php
$pagi->setLogger($logger);
```

By default, the client will use the [NullLogger](http://www.php-fig.org/psr/psr-3/#1-4-helper-classes-and-interfaces).

# Developers
This project uses [phing](https://www.phing.info/). Current tasks include:
 * test: Runs [PHPUnit](https://phpunit.de/).
 * cs: Runs [CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer).
 * doc: Runs [PhpDocumentor](http://www.phpdoc.org/).
 * md: runs [PHPMD](http://phpmd.org/).
 * build: This is the default task, and will run all the other tasks.

## Running a phing task
To run a task, just do:

```sh
vendor/bin/phing build
```

## Contributing
To contribute:
 * Make sure you open a **concise** and **short** pull request.
 * Throw in any needed unit tests to accomodate the new code or the
 changes involved.
 * Run `phing` and make sure everything is ok before submitting the pull
 request (make phpmd and CodeSniffer happy, also make sure that phpDocumentor
 does not throw any warnings, since all our documentation is automatically
 generated).
 * Your code must comply with [PSR-2](http://www.php-fig.org/psr/psr-2/),
 CodeSniffer should take care of that.

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

