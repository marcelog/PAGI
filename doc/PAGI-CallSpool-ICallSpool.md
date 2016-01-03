PAGI\CallSpool\ICallSpool
===============

An interface to access asterisk call spool.

PHP Version 5


* Interface name: ICallSpool
* Namespace: PAGI\CallSpool
* This is an **interface**






Methods
-------


### spool

    void PAGI\CallSpool\ICallSpool::spool(\PAGI\CallSpool\CallFile $call, integer $schedule)

Spools the given call.



* Visibility: **public**


#### Arguments
* $call **[PAGI\CallSpool\CallFile](PAGI-CallSpool-CallFile.md)** - &lt;p&gt;Call to spool.&lt;/p&gt;
* $schedule **integer** - &lt;p&gt;Optional unix timestamp to schedule the call.&lt;/p&gt;


