PAGI\Client\Result\ResultDecorator
===============

A result decorator.

PHP Version 5


* Class name: ResultDecorator
* Namespace: PAGI\Client\Result
* This is an **abstract** class
* This class implements: [PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)




Properties
----------


### $result

    private \PAGI\Client\Result\IResult $result

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




### __toString

    string PAGI\Client\Result\ResultDecorator::__toString()

Standard procedure.



* Visibility: **public**




### __construct

    void PAGI\Client\Result\ResultDecorator::__construct(\PAGI\Client\Result\IResult $result)

Constructor.



* Visibility: **public**


#### Arguments
* $result **[PAGI\Client\Result\IResult](PAGI-Client-Result-IResult.md)** - &lt;p&gt;Result to decorate.&lt;/p&gt;


