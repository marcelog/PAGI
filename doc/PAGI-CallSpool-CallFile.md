PAGI\CallSpool\CallFile
===============

A call file facade.

PHP Version 5


* Class name: CallFile
* Namespace: PAGI\CallSpool





Properties
----------


### $parameters

    private array<mixed,string> $parameters

Parameters.



* Visibility: **private**


### $variables

    private array<mixed,string> $variables

Variables.



* Visibility: **private**


Methods
-------


### getParameter

    string PAGI\CallSpool\CallFile::getParameter(string $key)

Returns the value for the given parameter.



* Visibility: **protected**


#### Arguments
* $key **string** - &lt;p&gt;Parameter name.&lt;/p&gt;



### setParameter

    void PAGI\CallSpool\CallFile::setParameter(string $key, string $value)

Sets a given parameter with the given value.



* Visibility: **protected**


#### Arguments
* $key **string** - &lt;p&gt;Parameter name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Value.&lt;/p&gt;



### getVariable

    string PAGI\CallSpool\CallFile::getVariable(string $key)

Returns the value for the given variable.



* Visibility: **public**


#### Arguments
* $key **string** - &lt;p&gt;Variable name.&lt;/p&gt;



### setVariable

    void PAGI\CallSpool\CallFile::setVariable(string $key, string $value)

Sets a given variable with the given value.



* Visibility: **public**


#### Arguments
* $key **string** - &lt;p&gt;Variable name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Value.&lt;/p&gt;



### getChannel

    string PAGI\CallSpool\CallFile::getChannel()

Returns channel to use for the call.



* Visibility: **public**




### getCallerId

    string PAGI\CallSpool\CallFile::getCallerId()

Returns Caller ID, Please note: It may not work if you do not respect
the format: CallerID: "Some Name" <1234>



* Visibility: **public**




### setCallerId

    void PAGI\CallSpool\CallFile::setCallerId(string $value)

Sets the Caller ID, Please note: It may not work if you do not respect
the format: CallerID: "Some Name" <1234>



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getWaitTime

    integer PAGI\CallSpool\CallFile::getWaitTime()

Returns seconds to wait for an answer. Default is 45.



* Visibility: **public**




### setWaitTime

    void PAGI\CallSpool\CallFile::setWaitTime(integer $value)

Sets seconds to wait for an answer. Default is 45.



* Visibility: **public**


#### Arguments
* $value **integer** - &lt;p&gt;Value to set.&lt;/p&gt;



### getMaxRetries

    integer PAGI\CallSpool\CallFile::getMaxRetries()

Returns number of retries before failing (not including the initial
attempt, e.g. 0 = total of 1 attempt to make the call). Default is 0.



* Visibility: **public**




### setMaxRetries

    void PAGI\CallSpool\CallFile::setMaxRetries(integer $value)

Sets number of retries before failing (not including the initial
attempt, e.g. 0 = total of 1 attempt to make the call). Default is 0.



* Visibility: **public**


#### Arguments
* $value **integer** - &lt;p&gt;Value to set.&lt;/p&gt;



### getRetryTime

    integer PAGI\CallSpool\CallFile::getRetryTime()

Returns seconds between retries, Don't hammer an unavailable phone.

Default is 300 (5 min).

* Visibility: **public**




### setRetryTime

    void PAGI\CallSpool\CallFile::setRetryTime(integer $value)

Sets seconds between retries, Don't hammer an unavailable phone.

Default is 300 (5 min).

* Visibility: **public**


#### Arguments
* $value **integer** - &lt;p&gt;Value to set.&lt;/p&gt;



### getAccount

    string PAGI\CallSpool\CallFile::getAccount()

Returns account code to use for this call.



* Visibility: **public**




### setAccount

    void PAGI\CallSpool\CallFile::setAccount(string $value)

Sets account code to use for this call.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getContext

    string PAGI\CallSpool\CallFile::getContext()

Returns context to use for this call when answered.



* Visibility: **public**




### setContext

    void PAGI\CallSpool\CallFile::setContext(string $value)

Sets context to use for this call when answered.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getPriority

    string PAGI\CallSpool\CallFile::getPriority()

Returns priority to use for this call when answered.



* Visibility: **public**




### setPriority

    void PAGI\CallSpool\CallFile::setPriority(string $value)

Sets priority to use for this call when answered.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getExtension

    string PAGI\CallSpool\CallFile::getExtension()

Returns extension to use for this call when answered.



* Visibility: **public**




### setExtension

    void PAGI\CallSpool\CallFile::setExtension(string $value)

Sets extension to use for this call when answered.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getApplication

    string PAGI\CallSpool\CallFile::getApplication()

Returns Asterisk Application to run (use instead of specifiying context,
extension and priority)



* Visibility: **public**




### setApplication

    void PAGI\CallSpool\CallFile::setApplication(string $value)

Sets Asterisk Application to run (use instead of specifiying context,
extension and priority)



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getApplicationData

    string PAGI\CallSpool\CallFile::getApplicationData()

Returns the options to be passed to application.



* Visibility: **public**




### setApplicationData

    void PAGI\CallSpool\CallFile::setApplicationData(array $options)

Sets the options to be passed to application.



* Visibility: **public**


#### Arguments
* $options **array**



### getAlwaysDelete

    boolean PAGI\CallSpool\CallFile::getAlwaysDelete()

If the file's modification time is in the future, the call file will not
be deleted



* Visibility: **public**




### setAlwaysDelete

    void PAGI\CallSpool\CallFile::setAlwaysDelete(boolean $value)

If the file's modification time is in the future, the call file will not
be deleted



* Visibility: **public**


#### Arguments
* $value **boolean** - &lt;p&gt;Value to set.&lt;/p&gt;



### getArchive

    boolean PAGI\CallSpool\CallFile::getArchive()

Sets if should move to subdir "outgoing_done" with "Status: value",
where value can be Completed, Expired or Failed.



* Visibility: **public**




### setArchive

    void PAGI\CallSpool\CallFile::setArchive(boolean $value)

Sets if should move to subdir "outgoing_done" with "Status: value",
where value can be Completed, Expired or Failed.



* Visibility: **public**


#### Arguments
* $value **boolean** - &lt;p&gt;Value to set.&lt;/p&gt;



### serialize

    string PAGI\CallSpool\CallFile::serialize()

Returns the text describing this call file, ready to be spooled.



* Visibility: **public**




### unserialize

    void PAGI\CallSpool\CallFile::unserialize(string $text)

Deconstructs a call file from the given text.



* Visibility: **public**


#### Arguments
* $text **string** - &lt;p&gt;A call file (intended to be pre-loaded, with
file_get_contents() or similar).&lt;/p&gt;



### __construct

    void PAGI\CallSpool\CallFile::__construct(\PAGI\DialDescriptor\DialDescriptor $dialDescriptor)

Constructor.



* Visibility: **public**


#### Arguments
* $dialDescriptor **[PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)**


