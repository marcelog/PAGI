PAGI\Client\Result\RecordResult
===============

A record result.

PHP Version 5


* Class name: RecordResult
* Namespace: PAGI\Client\Result
* Parent class: [PAGI\Client\Result\ResultDecorator](PAGI-Client-Result-ResultDecorator.md)





Properties
----------


### $hangup

    private boolean $hangup

Was the record interrupted because of a hangup?



* Visibility: **private**


### $dtmf

    private boolean $dtmf

Was the record interrupted because of a dtmf?



* Visibility: **private**


### $waitfor

    private boolean $waitfor

Error because of "waitfor"?



* Visibility: **private**


### $writefile

    private boolean $writefile

Error creating/writing/accessing the file?



* Visibility: **private**


### $failed

    private boolean $failed

Was this record a failure?



* Visibility: **private**


### $endpos

    private integer $endpos

Ending position for the recording.



* Visibility: **private**


### $digits

    private string $digits

Digit pressed (if any).



* Visibility: **private**


### $result

    private \PAGI\Client\Result\IResult $result

Our decorated result.



* Visibility: **private**


Methods
-------


### isInterrupted

    boolean PAGI\Client\Result\RecordResult::isInterrupted()

Returns true if this recording was interrupted by either a hangup or a
dtmf press.



* Visibility: **public**




### isHangup

    boolean PAGI\Client\Result\RecordResult::isHangup()

Did the user hangup the call?



* Visibility: **public**




### getEndPos

    integer PAGI\Client\Result\RecordResult::getEndPos()

Returns ending position for this recording.



* Visibility: **public**




### getDigits

    string PAGI\Client\Result\RecordResult::getDigits()

Returns the digit pressed to stop this recording (false if none).



* Visibility: **public**




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




### __toString

    string PAGI\Client\Result\ResultDecorator::__toString()

Standard procedure.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\ResultDecorator](PAGI-Client-Result-ResultDecorator.md)



