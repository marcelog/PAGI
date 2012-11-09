PAGI
====

This framework is intended to simply making IVR applications using Asterisk's AGI, providing a nice level of
abstraction over what an IVR should look like from a developers' perspective.

```php
<?php

require_once __DIR__.'/../vendor/autoload.php';

class MyApplication extends PAGI\Application\Application
{
	// @see docs/examples/quickstart
}

$client = PAGI\Client\Client::getInstance();

$app = new MyApplication($client);
$app->init();
$app->run();
```

PAGI works with PHP 5.3.3 or later.

Installation
------------

The recommended way to install PAGI is [through composer](http://getcomposer.org). Just create a `composer.json` file and
run the `php composer.phar install` command to install it:

```json
{
    "minimum-stability": "dev",
    "require": {
        "marcelog/pagi": "dev-master"
    }
}
```

Alternatively, you can download the [PAGI build](http://ci.marcelog.name:8080/job/PAGI/lastSuccessfulBuild/) file and extract it.

More Information
----------------

Read the [documentation](https://github.com/marcelog/PAGI/tree/master/doc) for more information.

Tests
------

To run the test suite, you need [composer](http://getcomposer.org) and [PHPUnit](https://github.com/sebastianbergmann/phpunit).

```bash
$ php composer.phar install --dev
$ phpunit
```

Contact me
----------

If you have any questions, issues, feature requests, or just want to report your "success story", or maybe
even say hi, please send an email to marcelog@gmail.com.

License
-------

PAGI is licensed under the Apache2 license.
