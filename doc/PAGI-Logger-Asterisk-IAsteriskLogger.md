PAGI\Logger\Asterisk\IAsteriskLogger
===============

Facade to access asterisk logger (see logger.conf in your asterisk
installation).

PHP Version 5


* Interface name: IAsteriskLogger
* Namespace: PAGI\Logger\Asterisk
* This is an **interface**






Methods
-------


### error

    void PAGI\Logger\Asterisk\IAsteriskLogger::error(string $msg)

Logs with priority ERROR.



* Visibility: **public**


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### warn

    void PAGI\Logger\Asterisk\IAsteriskLogger::warn(string $msg)

Logs with priority WARNING.



* Visibility: **public**


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### notice

    void PAGI\Logger\Asterisk\IAsteriskLogger::notice(string $msg)

Logs with priority NOTICE.



* Visibility: **public**


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### debug

    void PAGI\Logger\Asterisk\IAsteriskLogger::debug(string $msg)

Logs with priority DEBUG.



* Visibility: **public**


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### verbose

    void PAGI\Logger\Asterisk\IAsteriskLogger::verbose(string $msg)

Logs with priority VERBOSE.



* Visibility: **public**


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;



### dtmf

    void PAGI\Logger\Asterisk\IAsteriskLogger::dtmf(string $msg)

Logs with priority DTMF.



* Visibility: **public**


#### Arguments
* $msg **string** - &lt;p&gt;Message to log.&lt;/p&gt;


