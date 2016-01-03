PAGI\Client\Result\FaxResult
===============

This decorated result adds the functionality to check for a fax result.

PHP Version 5


* Class name: FaxResult
* Namespace: PAGI\Client\Result
* Parent class: [PAGI\Client\Result\ExecResult](PAGI-Client-Result-ExecResult.md)





Properties
----------


### $localId

    private string $localId

Local station ID.



* Visibility: **private**


### $localHeader

    private string $localHeader

Local header.



* Visibility: **private**


### $remoteId

    private string $remoteId

Remote station ID.



* Visibility: **private**


### $result

    private \PAGI\Client\Result\IResult $result

Our decorated result.



* Visibility: **private**


### $error

    private string $error

Error detail (if $result === false)



* Visibility: **private**


### $bitrate

    private integer $bitrate

Bitrate for the operation.



* Visibility: **private**


### $pages

    private integer $pages

Total pages for the operation.



* Visibility: **private**


### $resolution

    private string $resolution

Resolution for the operation.



* Visibility: **private**


Methods
-------


### getLocalStationId

    string PAGI\Client\Result\FaxResult::getLocalStationId()

Returns local station id.



* Visibility: **public**




### setLocalStationId

    void PAGI\Client\Result\FaxResult::setLocalStationId(string $value)

Sets local station id.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getLocalHeaderInfo

    string PAGI\Client\Result\FaxResult::getLocalHeaderInfo()

Returns local header.



* Visibility: **public**




### setLocalHeaderInfo

    void PAGI\Client\Result\FaxResult::setLocalHeaderInfo(string $value)

Sets local header.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### isSuccess

    boolean PAGI\Client\Result\FaxResult::isSuccess()

True if the operation was successfull.



* Visibility: **public**




### setResult

    void PAGI\Client\Result\FaxResult::setResult(string $value)

Sets operation result (if failed).



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getError

    string PAGI\Client\Result\FaxResult::getError()

Returns error description (if failed).



* Visibility: **public**




### setError

    void PAGI\Client\Result\FaxResult::setError(string $value)

Sets error detail.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getRemoteStationId

    string PAGI\Client\Result\FaxResult::getRemoteStationId()

Returns remote station id.



* Visibility: **public**




### setRemoteStationId

    void PAGI\Client\Result\FaxResult::setRemoteStationId(string $value)

Sets remote station id.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



### getPages

    integer PAGI\Client\Result\FaxResult::getPages()

Returns number of pages.



* Visibility: **public**




### setPages

    void PAGI\Client\Result\FaxResult::setPages(integer $value)

Sets number of pages.



* Visibility: **public**


#### Arguments
* $value **integer** - &lt;p&gt;Value to set.&lt;/p&gt;



### getBitrate

    integer PAGI\Client\Result\FaxResult::getBitrate()

Returns bitrate.



* Visibility: **public**




### setBitrate

    void PAGI\Client\Result\FaxResult::setBitrate(integer $value)

Sets bitrate.



* Visibility: **public**


#### Arguments
* $value **integer** - &lt;p&gt;Value to set.&lt;/p&gt;



### getResolution

    string PAGI\Client\Result\FaxResult::getResolution()

Returns resolution for the operation.



* Visibility: **public**




### setResolution

    void PAGI\Client\Result\FaxResult::setResolution(string $value)

Sets resolution.



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Value to set.&lt;/p&gt;



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



