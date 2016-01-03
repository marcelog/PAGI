PAGI\Client\Result\DigitReadResult
===============

This decorated result adds the functionality to check for user input. We
need a distinction between a single digit read (this class) and a data read
(DataReadResult) because asterisk sends the ascii number for the character
read (the first case) and the literal string in the latter.

PHP Version 5


* Class name: DigitReadResult
* Namespace: PAGI\Client\Result
* Parent class: [PAGI\Client\Result\ResultDecorator](PAGI-Client-Result-ResultDecorator.md)
* This class implements: [PAGI\Client\Result\IReadResult](PAGI-Client-Result-IReadResult.md)




Properties
----------


### $digits

    protected string $digits

Digits read (if any).



* Visibility: **protected**


### $timeout

    protected boolean $timeout

Timeout?



* Visibility: **protected**


### $result

    private \PAGI\Client\Result\IResult $result

Our decorated result.



* Visibility: **private**


Methods
-------


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



