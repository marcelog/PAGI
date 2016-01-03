PAGI\CDR\Impl\CDRFacade
===============

CDR Facade.

If the channel has a cdr, that cdr record has it's own set of variables which
can be accessed just like channel variables. The following builtin variables
are available and, unless specified, read-only.

${CDR(clid)}  Caller ID
${CDR(src)}   Source
${CDR(dst)}   Destination
${CDR(dcontext)}  Destination context
${CDR(channel)}   Channel name
${CDR(dstchannel)}    Destination channel
${CDR(lastapp)}   Last app executed
${CDR(lastdata)}  Last app's arguments
${CDR(start)}     Time the call started.
${CDR(answer)}    Time the call was answered.
${CDR(end)}   Time the call ended.
${CDR(duration)}  Duration of the call.
${CDR(billsec)}   Duration of the call once it was answered.
${CDR(disposition)}   ANSWERED, NO ANSWER, BUSY
${CDR(amaflags)}  DOCUMENTATION, BILL, IGNORE etc
${CDR(accountcode)}   The channel's account code (read-write).
${CDR(uniqueid)}  The channel's unique id.
${CDR(userfield)}     The channels uses specified field (read-write).


In addition, you can set your own extra variables with a traditional
Set(CDR(var)=val) to anything you want.

NOTE Some CDR values (eg: duration & billsec) can't be accessed until the call
has terminated. As of 91617, those values will be calculated on-demand if
requested. Until that makes it into a stable release, you can set
endbeforehexten=yes in cdr.conf, and then use the "hangup" context to wrap
up your call.

PHP Version 5


* Class name: CDRFacade
* Namespace: PAGI\CDR\Impl
* This class implements: [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




Properties
----------


### $client

    private \PAGI\Client\IClient $client

AGI Client, needed to access cdr data.



* Visibility: **private**


Methods
-------


### setUserfield

    void PAGI\CDR\ICDR::setUserfield(string $value)

Set userfileds for cdr. CDR(userfield).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)


#### Arguments
* $value **string** - &lt;p&gt;New userfields to use.&lt;/p&gt;



### getUserfield

    string PAGI\CDR\ICDR::getUserfield()

The channels uses specified field (read-write). CDR(userfield).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getUniqueId

    string PAGI\CDR\ICDR::getUniqueId()

The channel uniqueid. CDR(uniqueid).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### setAccountCode

    void PAGI\CDR\ICDR::setAccountCode(string $value)

Sets account code. CDR(accountcode).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)


#### Arguments
* $value **string** - &lt;p&gt;New account code.&lt;/p&gt;



### getAccountCode

    string PAGI\CDR\ICDR::getAccountCode()

The channel account code. CDR(accountcode).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getAMAFlags

    string PAGI\CDR\ICDR::getAMAFlags()

DOCUMENTATION, BILL, IGNORE etc. CDR(amaflags).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getStatus

    string PAGI\CDR\ICDR::getStatus()

Call result. CDR(disposition).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getAnswerLength

    string PAGI\CDR\ICDR::getAnswerLength()

Total answered time for the call in seconds. CDR(billsec).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getTotalLength

    string PAGI\CDR\ICDR::getTotalLength()

Total length of the call in seconds. CDR(duration).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getEndTime

    string PAGI\CDR\ICDR::getEndTime()

Time the call ended. CDR(end).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getAnswerTime

    string PAGI\CDR\ICDR::getAnswerTime()

Time the call was answered. CDR(answer).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getStartTime

    string PAGI\CDR\ICDR::getStartTime()

Time the call started. CDR(start).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getLastAppData

    string PAGI\CDR\ICDR::getLastAppData()

Returns Last application data. CDR(lastdata).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getLastApp

    string PAGI\CDR\ICDR::getLastApp()

Returns Last application. CDR(lastapp).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getChannel

    string PAGI\CDR\ICDR::getChannel()

Returns origin channel. CDR(channel).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getDestinationChannel

    string PAGI\CDR\ICDR::getDestinationChannel()

Returns destination channel. CDR(dstchannel).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getCallerId

    string PAGI\CDR\ICDR::getCallerId()

Returns caller id. CDR(clid).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getSource

    string PAGI\CDR\ICDR::getSource()

Returns origin. CDR(src).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getDestination

    string PAGI\CDR\ICDR::getDestination()

Returns destination. CDR(dst).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getDestinationContext

    string PAGI\CDR\ICDR::getDestinationContext()

Returns destination context. CDR(dcontext).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)




### getCustom

    string PAGI\CDR\ICDR::getCustom(string $name)

Returns a custom field in the cdr. CDR(name)



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)


#### Arguments
* $name **string** - &lt;p&gt;Field name.&lt;/p&gt;



### setCustom

    void PAGI\CDR\ICDR::setCustom(string $name, string $value)

Sets a custom field in the cdr. CDR(name).



* Visibility: **public**
* This method is defined by [PAGI\CDR\ICDR](PAGI-CDR-ICDR.md)


#### Arguments
* $name **string** - &lt;p&gt;Field name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Field value.&lt;/p&gt;



### getCDRVariable

    string PAGI\CDR\Impl\CDRFacade::getCDRVariable(string $name)

Access AGI client to get the variables.



* Visibility: **protected**


#### Arguments
* $name **string** - &lt;p&gt;Variable name.&lt;/p&gt;



### setCDRVariable

    void PAGI\CDR\Impl\CDRFacade::setCDRVariable(string $name, string $value)

Access AGI client to set the variable.



* Visibility: **protected**


#### Arguments
* $name **string** - &lt;p&gt;Variable name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Value.&lt;/p&gt;



### __construct

    void PAGI\CDR\Impl\CDRFacade::__construct(\PAGI\Client\IClient $client)

Constructor.



* Visibility: **public**


#### Arguments
* $client **[PAGI\Client\IClient](PAGI-Client-IClient.md)** - &lt;p&gt;AGI Client.&lt;/p&gt;


