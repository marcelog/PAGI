PAGI\Logger\Asterisk\Impl\MockedAsteriskLoggerImpl
===============

This will log to client logger instead of asterisk.

PHP Version 5


* Class name: MockedAsteriskLoggerImpl
* Namespace: PAGI\Logger\Asterisk\Impl
* This class implements: [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)




Properties
----------


### $logger

    private \Logger $logger = false

Logger to use.



* Visibility: **private**


Methods
-------


### error

    void PAGI\Logger\Asterisk\IAsteriskLogger::error(string $msg)

Logs with priority ERROR.



* Visibility: **public**
* This method is defined by [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### warn

    void PAGI\Logger\Asterisk\IAsteriskLogger::warn(string $msg)

Logs with priority WARNING.



* Visibility: **public**
* This method is defined by [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### notice

    void PAGI\Logger\Asterisk\IAsteriskLogger::notice(string $msg)

Logs with priority NOTICE.



* Visibility: **public**
* This method is defined by [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### debug

    void PAGI\Logger\Asterisk\IAsteriskLogger::debug(string $msg)

Logs with priority DEBUG.



* Visibility: **public**
* This method is defined by [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### verbose

    void PAGI\Logger\Asterisk\IAsteriskLogger::verbose(string $msg)

Logs with priority VERBOSE.



* Visibility: **public**
* This method is defined by [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### dtmf

    void PAGI\Logger\Asterisk\IAsteriskLogger::dtmf(string $msg)

Logs with priority DTMF.



* Visibility: **public**
* This method is defined by [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### __construct

    void PAGI\Logger\Asterisk\Impl\MockedAsteriskLoggerImpl::__construct(\Logger $logger)

Constructor.



* Visibility: **public**


#### Arguments
* $logger **Logger**


