PAGI\Logger\Asterisk\Impl\AsteriskLoggerImpl
===============

Facade to access asterisk logger (see logger.conf in your asterisk
installation).

PHP Version 5


* Class name: AsteriskLoggerImpl
* Namespace: PAGI\Logger\Asterisk\Impl
* This class implements: [PAGI\Logger\Asterisk\IAsteriskLogger](PAGI-Logger-Asterisk-IAsteriskLogger.md)




Properties
----------


### $agi

    private \PAGI\Client\IClient $agi = false

Holds instance of AGI Client.



* Visibility: **private**


### $ident

    private mixed $ident

Holds identity to prepend.



* Visibility: **private**


### $instance

    private \PAGI\Logger\Asterisk\Impl\AsteriskLoggerImpl $instance = false

Holds current instance.



* Visibility: **private**
* This property is **static**.


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



### getLogger

    void PAGI\Logger\Asterisk\Impl\AsteriskLoggerImpl::getLogger(\PAGI\Client\IClient $agi)

Obtains an instance for this facade.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $agi **[PAGI\Client\IClient](PAGI-Client-IClient.md)** - &lt;p&gt;Client AGI to use.&lt;/p&gt;



### __construct

    void PAGI\Logger\Asterisk\Impl\AsteriskLoggerImpl::__construct(\PAGI\Client\IClient $agi)

Constructor.



* Visibility: **protected**


#### Arguments
* $agi **[PAGI\Client\IClient](PAGI-Client-IClient.md)** - &lt;p&gt;AGI client.&lt;/p&gt;


