PAGI\Client\Result\ReadResultDecorator
===============

A result decorator.

PHP Version 5


* Class name: ReadResultDecorator
* Namespace: PAGI\Client\Result
* This is an **abstract** class
* This class implements: [PAGI\Client\Result\IReadResult](PAGI-Client-Result-IReadResult.md)




Properties
----------


### $result

    private \PAGI\Client\Result\IReadResult $result

Our decorated result.



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




### isTimeout

    boolean PAGI\Client\Result\IReadResult::isTimeout()

True if the operation completed and no input was received from the user.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IReadResult](PAGI-Client-Result-IReadResult.md)




### getDigits

    string PAGI\Client\Result\IReadResult::getDigits()

Returns digits read. False if none.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IReadResult](PAGI-Client-Result-IReadResult.md)




### getDigitsCount

    integer PAGI\Client\Result\IReadResult::getDigitsCount()

Returns the number of digits read.



* Visibility: **public**
* This method is defined by [PAGI\Client\Result\IReadResult](PAGI-Client-Result-IReadResult.md)




### __toString

    mixed PAGI\Client\Result\ReadResultDecorator::__toString()

Standard drill.



* Visibility: **public**




### __construct

    mixed PAGI\Client\Result\ReadResultDecorator::__construct(\PAGI\Client\Result\IReadResult $result)

Constructor.



* Visibility: **public**


#### Arguments
* $result **[PAGI\Client\Result\IReadResult](PAGI-Client-Result-IReadResult.md)** - &lt;p&gt;Result to decorate.&lt;/p&gt;


