PAGI\Client\Result\AmdResult
===============

This decorated result adds the functionality to check for an AMD result.

PHP Version 5


* Class name: AmdResult
* Namespace: PAGI\Client\Result
* Parent class: [PAGI\Client\Result\ExecResult](PAGI-Client-Result-ExecResult.md)





Properties
----------


### $status

    private string $status

Cause



* Visibility: **private**


### $cause

    private string $cause

Cause



* Visibility: **private**


### $result

    private \PAGI\Client\Result\IResult $result

Our decorated result.



* Visibility: **private**


Methods
-------


### getCause

    string PAGI\Client\Result\AmdResult::getCause()

Returns the cause string.



* Visibility: **public**




### getStatus

    string PAGI\Client\Result\AmdResult::getStatus()

Returns the status string.



* Visibility: **public**




### setCause

    void PAGI\Client\Result\AmdResult::setCause(string $cause)

Sets the cause string



* Visibility: **public**


#### Arguments
* $cause **string**



### setStatus

    void PAGI\Client\Result\AmdResult::setStatus($status)

Sets the cause string



* Visibility: **public**


#### Arguments
* $status **mixed**



### isStatus

    boolean PAGI\Client\Result\AmdResult::isStatus(string $string)

True if the status equals the given string



* Visibility: **private**


#### Arguments
* $string **string**



### isCause

    boolean PAGI\Client\Result\AmdResult::isCause(string $string)

True if the cause equals the given string



* Visibility: **private**


#### Arguments
* $string **string**



### isMachine

    boolean PAGI\Client\Result\AmdResult::isMachine()

True if AMD detected an answering machine.



* Visibility: **public**




### isHangup

    boolean PAGI\Client\Result\AmdResult::isHangup()

True if AMD detected a hangup.



* Visibility: **public**




### isHuman

    boolean PAGI\Client\Result\AmdResult::isHuman()

True if AMD detected a human.



* Visibility: **public**




### isNotSure

    boolean PAGI\Client\Result\AmdResult::isNotSure()

True if AMD failed detecting an answering machine or human.



* Visibility: **public**




### isCauseTooLong

    boolean PAGI\Client\Result\AmdResult::isCauseTooLong()

True if AMD status is due to a timeout when detecting.



* Visibility: **public**




### isCauseInitialSilence

    boolean PAGI\Client\Result\AmdResult::isCauseInitialSilence()

True if AMD status is due to a silence duration.



* Visibility: **public**




### isCauseHuman

    boolean PAGI\Client\Result\AmdResult::isCauseHuman()

True if AMD status is due to a silence after a greeting.



* Visibility: **public**




### isCauseGreeting

    boolean PAGI\Client\Result\AmdResult::isCauseGreeting()

True if AMD status is due to a long greeting detected.



* Visibility: **public**




### isCauseWordLength

    boolean PAGI\Client\Result\AmdResult::isCauseWordLength()

True if AMD status is due to a maximum number of words reached.



* Visibility: **public**




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



