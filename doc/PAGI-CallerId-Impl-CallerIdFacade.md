PAGI\CallerId\Impl\CallerIdFacade
===============

AGI Caller id facade.

PHP Version 5


* Class name: CallerIdFacade
* Namespace: PAGI\CallerId\Impl
* This class implements: [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)




Properties
----------


### $client

    private \PAGI\Client\IClient $client

Instance of client to access caller id variables.



* Visibility: **private**


Methods
-------


### setANI

    void PAGI\CallerId\ICallerId::setANI(string $value)

Sets caller id ani. CALLERID(ani).



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)


#### Arguments
* $value **string** - &lt;p&gt;ANI.&lt;/p&gt;



### getANI

    string PAGI\CallerId\ICallerId::getANI()

Returns caller id ani. CALLERID(ani)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)




### setDNID

    void PAGI\CallerId\ICallerId::setDNID(string $value)

Sets caller id dnid. CALLERID(dnid)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)


#### Arguments
* $value **string** - &lt;p&gt;DNID.&lt;/p&gt;



### getDNID

    string PAGI\CallerId\ICallerId::getDNID()

Returns caller id dnid. CALLERID(dnid)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)




### setRDNIS

    void PAGI\CallerId\ICallerId::setRDNIS(string $value)

Sets caller id rdnis. CALLERID(rdnis)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)


#### Arguments
* $value **string** - &lt;p&gt;RDNIS.&lt;/p&gt;



### getRDNIS

    string PAGI\CallerId\ICallerId::getRDNIS()

Returns caller id rdnis. CALLERID(rdnis)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)




### setName

    void PAGI\CallerId\ICallerId::setName(string $value)

Sets caller id name. CALLERID(name)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)


#### Arguments
* $value **string** - &lt;p&gt;Name.&lt;/p&gt;



### getName

    string PAGI\CallerId\ICallerId::getName()

Returns caller id name. CALLERID(name)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)




### getNumber

    string PAGI\CallerId\ICallerId::getNumber()

Returns caller id number. CALLERID(num)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)




### setNumber

    void PAGI\CallerId\ICallerId::setNumber(string $value)

Sets caller id number. CALLERID(num)



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)


#### Arguments
* $value **string** - &lt;p&gt;Number.&lt;/p&gt;



### getCallerIdVariable

    string PAGI\CallerId\Impl\CallerIdFacade::getCallerIdVariable(string $name)

Access AGI client to get the variables.



* Visibility: **protected**


#### Arguments
* $name **string** - &lt;p&gt;Variable name.&lt;/p&gt;



### setCallerIdVariable

    void PAGI\CallerId\Impl\CallerIdFacade::setCallerIdVariable(string $name, string $value)

Access AGI client to set the variable.



* Visibility: **protected**


#### Arguments
* $name **string** - &lt;p&gt;Variable name.&lt;/p&gt;
* $value **string** - &lt;p&gt;Value.&lt;/p&gt;



### setCallerPres

    void PAGI\CallerId\ICallerId::setCallerPres(string $presentationMode)

Changes the caller id presentation mode.



* Visibility: **public**
* This method is defined by [PAGI\CallerId\ICallerId](PAGI-CallerId-ICallerId.md)


#### Arguments
* $presentationMode **string** - &lt;p&gt;Can be one of:
allowed_not_screened - Presentation Allowed, Not Screened.
allowed_passed_screen - Presentation Allowed, Passed Screen.
allowed_failed_screen - Presentation Allowed, Failed Screen.
allowed - Presentation Allowed, Network Number.
prohib_not_screened - Presentation Prohibited, Not Screened.
prohib_passed_screen - Presentation Prohibited, Passed Screen.
prohib_failed_screen - Presentation Prohibited, Failed Screen.
prohib - Presentation Prohibited, Network Number.
unavailable - Number Unavailable.&lt;/p&gt;



### __toString

    string PAGI\CallerId\Impl\CallerIdFacade::__toString()

Standard procedure.



* Visibility: **public**




### __construct

    void PAGI\CallerId\Impl\CallerIdFacade::__construct(\PAGI\Client\IClient $client)

Constructor.



* Visibility: **public**


#### Arguments
* $client **[PAGI\Client\IClient](PAGI-Client-IClient.md)** - &lt;p&gt;AGI Client to use.&lt;/p&gt;


