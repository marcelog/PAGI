PAGI\CallSpool\Impl\CallSpoolImpl
===============

An implementation for asterisk call spool.

PHP Version 5


* Class name: CallSpoolImpl
* Namespace: PAGI\CallSpool\Impl
* This class implements: [PAGI\CallSpool\ICallSpool](PAGI-CallSpool-ICallSpool.md)




Properties
----------


### $tmpDir

    private string $tmpDir = '/tmp'

Where to temporary generate call files.



* Visibility: **private**


### $spoolDir

    private string $spoolDir = '/var/spool/asterisk'

Asterisk spool directory.



* Visibility: **private**


### $instance

    private \PAGI\CallSpool\Impl\CallSpoolImpl $instance = false

Current instance.



* Visibility: **private**
* This property is **static**.


Methods
-------


### getInstance

    \PAGI\CallSpool\Impl\CallSpoolImpl PAGI\CallSpool\Impl\CallSpoolImpl::getInstance(array<mixed,string> $options)

Returns an instance for this spool/



* Visibility: **public**
* This method is **static**.


#### Arguments
* $options **array&lt;mixed,string&gt;** - &lt;p&gt;Configuration options.&lt;/p&gt;



### spool

    void PAGI\CallSpool\ICallSpool::spool(\PAGI\CallSpool\CallFile $call, integer $schedule)

Spools the given call.



* Visibility: **public**
* This method is defined by [PAGI\CallSpool\ICallSpool](PAGI-CallSpool-ICallSpool.md)


#### Arguments
* $call **[PAGI\CallSpool\CallFile](PAGI-CallSpool-CallFile.md)** - &lt;p&gt;Call to spool.&lt;/p&gt;
* $schedule **integer** - &lt;p&gt;Optional unix timestamp to schedule the call.&lt;/p&gt;



### __construct

    void PAGI\CallSpool\Impl\CallSpoolImpl::__construct(array<mixed,string> $options)

Constructor.



* Visibility: **private**


#### Arguments
* $options **array&lt;mixed,string&gt;** - &lt;p&gt;Options for this spool.&lt;/p&gt;


