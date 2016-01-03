PAGI\Client\Result\IReadResult
===============

Interface for a read result, so it can be decorated later.

PHP Version 5


* Interface name: IReadResult
* Namespace: PAGI\Client\Result
* This is an **interface**
* This interface extends: [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)





Methods
-------


### isTimeout

    boolean PAGI\Client\Result\IReadResult::isTimeout()

True if the operation completed and no input was received from the user.



* Visibility: **public**




### getDigits

    string PAGI\Client\Result\IReadResult::getDigits()

Returns digits read. False if none.



* Visibility: **public**




### getDigitsCount

    integer PAGI\Client\Result\IReadResult::getDigitsCount()

Returns the number of digits read.



* Visibility: **public**




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



