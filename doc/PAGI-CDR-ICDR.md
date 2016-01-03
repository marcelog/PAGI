PAGI\CDR\ICDR
===============

CDR facade. Use this to access cdr variables.

PHP Version 5


* Interface name: ICDR
* Namespace: PAGI\CDR
* This is an **interface**






Methods
-------


### setUserfield

    void PAGI\CDR\ICDR::setUserfield(string $value)

Set userfileds for cdr. CDR(userfield).



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;New userfields to use.&lt;/p&gt;



### getUserfield

    string PAGI\CDR\ICDR::getUserfield()

The channels uses specified field (read-write). CDR(userfield).



* Visibility: **public**




### getUniqueId

    string PAGI\CDR\ICDR::getUniqueId()

The channel uniqueid. CDR(uniqueid).



* Visibility: **public**




### setAccountCode

    void PAGI\CDR\ICDR::setAccountCode(string $value)

Sets account code. CDR(accountcode).



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;New account code.&lt;/p&gt;



### getAccountCode

    string PAGI\CDR\ICDR::getAccountCode()

The channel account code. CDR(accountcode).



* Visibility: **public**




### getAMAFlags

    string PAGI\CDR\ICDR::getAMAFlags()

DOCUMENTATION, BILL, IGNORE etc. CDR(amaflags).



* Visibility: **public**




### getStatus

    string PAGI\CDR\ICDR::getStatus()

Call result. CDR(disposition).



* Visibility: **public**




### getAnswerLength

    string PAGI\CDR\ICDR::getAnswerLength()

Total answered time for the call in seconds. CDR(billsec).



* Visibility: **public**




### getTotalLength

    string PAGI\CDR\ICDR::getTotalLength()

Total length of the call in seconds. CDR(duration).



* Visibility: **public**




### getEndTime

    string PAGI\CDR\ICDR::getEndTime()

Time the call ended. CDR(end).



* Visibility: **public**




### getAnswerTime

    string PAGI\CDR\ICDR::getAnswerTime()

Time the call was answered. CDR(answer).



* Visibility: **public**




### getStartTime

    string PAGI\CDR\ICDR::getStartTime()

Time the call started. CDR(start).



* Visibility: **public**




### getLastAppData

    string PAGI\CDR\ICDR::getLastAppData()

Returns Last application data. CDR(lastdata).



* Visibility: **public**




### getLastApp

    string PAGI\CDR\ICDR::getLastApp()

Returns Last application. CDR(lastapp).



* Visibility: **public**




### getChannel

    string PAGI\CDR\ICDR::getChannel()

Returns origin channel. CDR(channel).



* Visibility: **public**




### getDestinationChannel

    string PAGI\CDR\ICDR::getDestinationChannel()

Returns destination channel. CDR(dstchannel).



* Visibility: **public**




### getCallerId

    string PAGI\CDR\ICDR::getCallerId()

Returns caller id. CDR(clid).



* Visibility: **public**




### getSource

    string PAGI\CDR\ICDR::getSource()

Returns origin. CDR(src).



* Visibility: **public**




### getDestination

    string PAGI\CDR\ICDR::getDestination()

Returns destination. CDR(dst).



* Visibility: **public**




### getDestinationContext

    string PAGI\CDR\ICDR::getDestinationContext()

Returns destination context. CDR(dcontext).



* Visibility: **public**




### getCustom

    string PAGI\CDR\ICDR::getCustom(string $name)

Returns a custom field in the cdr. CDR(name)



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;Field name.&lt;/p&gt;



### setCustom

    void PAGI\CDR\ICDR::setCustom(string $name, string $value)

Sets a custom field in the cdr. CDR(name).



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;Field name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Field value.&lt;/p&gt;


