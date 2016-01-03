PAGI\Client\Result\Result
===============

This class parses and encapsulates the result from an agi command. You must
instantiate it with the result line as came from asterisk.

PHP Version 5


* Class name: Result
* Namespace: PAGI\Client\Result
* This class implements: [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)




Properties
----------


### $code

    private integer $code

Result code (3 digits).



* Visibility: **private**


### $result

    private string $result

Result string (if any), from result=xxxxx string.



* Visibility: **private**


### $data

    private string $data

Result data (if any).



* Visibility: **private**


### $line

    private string $line

AGI result line (i.e: xxx result=zzzzzz [yyyyyy])



* Visibility: **private**


Methods
-------


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

    string PAGI\Client\Result\Result::__toString()

Standard.



* Visibility: **public**




### __construct

    void PAGI\Client\Result\Result::__construct(string $line)

Constructor. Will parse the data that came from agi.



* Visibility: **public**


#### Arguments
* $line **string** - &lt;p&gt;Result literal as came from agi.&lt;/p&gt;


