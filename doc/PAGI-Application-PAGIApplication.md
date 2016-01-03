PAGI\Application\PAGIApplication
===============

Parent class for all PAGIApplications.

PHP Version 5


* Class name: PAGIApplication
* Namespace: PAGI\Application
* This is an **abstract** class





Properties
----------


### $logger

    protected \PAGI\Application\Logger $logger

PSR-3 logger.



* Visibility: **protected**


### $agiClient

    private \PAGI\Client\IClient $agiClient

AGI Client.



* Visibility: **private**


Methods
-------


### init

    void PAGI\Application\PAGIApplication::init()

Called to initialize the application



* Visibility: **public**
* This method is **abstract**.




### shutdown

    void PAGI\Application\PAGIApplication::shutdown()

Called when PHPvm is shutting down.



* Visibility: **public**
* This method is **abstract**.




### run

    void PAGI\Application\PAGIApplication::run()

Called to run the application, after calling init().



* Visibility: **public**
* This method is **abstract**.




### errorHandler

    boolean PAGI\Application\PAGIApplication::errorHandler(integer $type, string $message, string $file, integer $line)

Your error handler. Be careful when implementing this one.



* Visibility: **public**
* This method is **abstract**.


#### Arguments
* $type **integer** - &lt;p&gt;PHP Error type constant.&lt;/p&gt;
* $message **string** - &lt;p&gt;Human readable error message string.&lt;/p&gt;
* $file **string** - &lt;p&gt;File that triggered the error.&lt;/p&gt;
* $line **integer** - &lt;p&gt;Line that triggered the error.&lt;/p&gt;



### signalHandler

    void PAGI\Application\PAGIApplication::signalHandler(integer $signal)

Your signal handler. Be careful when implementing this one.



* Visibility: **public**
* This method is **abstract**.


#### Arguments
* $signal **integer** - &lt;p&gt;Signal catched.&lt;/p&gt;



### getAgi

    \PAGI\Client\IClient PAGI\Application\PAGIApplication::getAgi()

Returns AGI Client.



* Visibility: **protected**




### setLogger

    void PAGI\Application\PAGIApplication::setLogger(\PAGI\Application\Psr\Log\LoggerInterface $logger)

Sets the logger implementation.



* Visibility: **public**


#### Arguments
* $logger **PAGI\Application\Psr\Log\LoggerInterface** - &lt;p&gt;The PSR3-Logger&lt;/p&gt;



### __construct

    void PAGI\Application\PAGIApplication::__construct(array $properties)

Constructor. Will call set_error_handler() and pcntl_signal() to setup
your errorHandler() and signalHandler(). Also will call
register_shutdown_function() to register your shutdown() function.



* Visibility: **public**


#### Arguments
* $properties **array** - &lt;p&gt;Optional additional properties.&lt;/p&gt;


