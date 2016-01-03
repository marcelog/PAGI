PAGI\Client\Result\DialResult
===============

This decorated result adds the functionality to check for a dial result.

PHP Version 5


* Class name: DialResult
* Namespace: PAGI\Client\Result
* Parent class: [PAGI\Client\Result\ExecResult](PAGI-Client-Result-ExecResult.md)





Properties
----------


### $dialedPeerNumber

    private string $dialedPeerNumber

Dialed peer number.



* Visibility: **private**


### $dialedPeerName

    private string $dialedPeerName

Dialed peer name.



* Visibility: **private**


### $dialedTime

    private integer $dialedTime

Total call length in seconds.



* Visibility: **private**


### $answeredTime

    private integer $answeredTime

Total answered length in seconds.



* Visibility: **private**


### $dialStatus

    private string $dialStatus

Dial status.



* Visibility: **private**


### $dynamicFeatures

    private string $dynamicFeatures

Features available for the call.



* Visibility: **private**


### $result

    private \PAGI\Client\Result\IResult $result

Our decorated result.



* Visibility: **private**


Methods
-------


### getPeerNumber

    string PAGI\Client\Result\DialResult::getPeerNumber()

Returns Peer number.



* Visibility: **public**




### setPeerNumber

    void PAGI\Client\Result\DialResult::setPeerNumber(string $number)

Set peer number.



* Visibility: **public**


#### Arguments
* $number **string** - &lt;p&gt;Peer number.&lt;/p&gt;



### getPeerName

    string PAGI\Client\Result\DialResult::getPeerName()

Returns Peer name.



* Visibility: **public**




### setPeerName

    void PAGI\Client\Result\DialResult::setPeerName(string $name)

Set peer name.



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;Peer name.&lt;/p&gt;



### getDialedTime

    integer PAGI\Client\Result\DialResult::getDialedTime()

Returns total time for the call in seconds.



* Visibility: **public**




### setDialedTime

    void PAGI\Client\Result\DialResult::setDialedTime(integer $time)

Set dialed time.



* Visibility: **public**


#### Arguments
* $time **integer** - &lt;p&gt;Dialed time.&lt;/p&gt;



### getAnsweredTime

    integer PAGI\Client\Result\DialResult::getAnsweredTime()

Returns answered time.



* Visibility: **public**




### setAnsweredTime

    void PAGI\Client\Result\DialResult::setAnsweredTime(integer $time)

Set answered time.



* Visibility: **public**


#### Arguments
* $time **integer** - &lt;p&gt;Answered time.&lt;/p&gt;



### getDialStatus

    string PAGI\Client\Result\DialResult::getDialStatus()

Returns dial status.



* Visibility: **public**




### isBusy

    boolean PAGI\Client\Result\DialResult::isBusy()

Returns true if the result was BUSY.



* Visibility: **public**




### isCongestion

    boolean PAGI\Client\Result\DialResult::isCongestion()

Returns true if the result was CONGESTION.



* Visibility: **public**




### isCancel

    boolean PAGI\Client\Result\DialResult::isCancel()

Returns true if the result was CANCEL.



* Visibility: **public**




### isAnswer

    boolean PAGI\Client\Result\DialResult::isAnswer()

Returns true if the result was ANSWER.



* Visibility: **public**




### isNoAnswer

    boolean PAGI\Client\Result\DialResult::isNoAnswer()

Returns true if the result was NOANSWER.



* Visibility: **public**




### isChanUnavailable

    boolean PAGI\Client\Result\DialResult::isChanUnavailable()

Returns true if the result was CHANUNAVAIL.



* Visibility: **public**




### setDialStatus

    void PAGI\Client\Result\DialResult::setDialStatus(string $status)

Set dial status.



* Visibility: **public**


#### Arguments
* $status **string** - &lt;p&gt;Dial status.&lt;/p&gt;



### getDynamicFeatures

    string PAGI\Client\Result\DialResult::getDynamicFeatures()

Returns features available for the call.



* Visibility: **public**




### setDynamicFeatures

    void PAGI\Client\Result\DialResult::setDynamicFeatures(string $features)

Set features.



* Visibility: **public**


#### Arguments
* $features **string** - &lt;p&gt;Features.&lt;/p&gt;



### __toString

    string PAGI\Client\Result\ResultDecorator::__toString()

Standard procedure.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\ResultDecorator](PAGI-Client-Result-ResultDecorator.md)




### __construct

    void PAGI\Client\Result\ResultDecorator::__construct(\PAGI\Client\Result\IResult $result)

Constructor.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\ResultDecorator](PAGI-Client-Result-ResultDecorator.md)


#### Arguments
* $result **[PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)** - &lt;p&gt;Result to decorate.&lt;/p&gt;



### getOriginalLine

    string PAGI\Client\Result\IResult::getOriginalLine()

Returns original line.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)




### getCode

    integer PAGI\Client\Result\IResult::getCode()

Returns the integer value of the code returned by agi.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)




### getResult

    integer PAGI\Client\Result\IResult::getResult()

Returns result (result=xxx) from the result.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)




### isResult

    boolean PAGI\Client\Result\IResult::isResult(string $value)

Compares result to a given value.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)


#### Arguments
* $value **string** - &lt;p&gt;Value to match against.&lt;/p&gt;



### hasData

    boolean PAGI\Client\Result\IResult::hasData()

Returns true if this command returned any data.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)




### getData

    string PAGI\Client\Result\IResult::getData()

Returns data, if any. False if none.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)



