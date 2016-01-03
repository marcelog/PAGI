PAGI\CallerId\ICallerId
===============

AGI Caller id facade.

PHP Version 5


* Interface name: ICallerId
* Namespace: PAGI\CallerId
* This is an **interface**






Methods
-------


### setANI

    void PAGI\CallerId\ICallerId::setANI(string $value)

Sets caller id ani. CALLERID(ani).



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;ANI.&lt;/p&gt;



### getANI

    string PAGI\CallerId\ICallerId::getANI()

Returns caller id ani. CALLERID(ani)



* Visibility: **public**




### setDNID

    void PAGI\CallerId\ICallerId::setDNID(string $value)

Sets caller id dnid. CALLERID(dnid)



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;DNID.&lt;/p&gt;



### getDNID

    string PAGI\CallerId\ICallerId::getDNID()

Returns caller id dnid. CALLERID(dnid)



* Visibility: **public**




### setRDNIS

    void PAGI\CallerId\ICallerId::setRDNIS(string $value)

Sets caller id rdnis. CALLERID(rdnis)



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;RDNIS.&lt;/p&gt;



### getRDNIS

    string PAGI\CallerId\ICallerId::getRDNIS()

Returns caller id rdnis. CALLERID(rdnis)



* Visibility: **public**




### setName

    void PAGI\CallerId\ICallerId::setName(string $value)

Sets caller id name. CALLERID(name)



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Name.&lt;/p&gt;



### getName

    string PAGI\CallerId\ICallerId::getName()

Returns caller id name. CALLERID(name)



* Visibility: **public**




### getNumber

    string PAGI\CallerId\ICallerId::getNumber()

Returns caller id number. CALLERID(num)



* Visibility: **public**




### setNumber

    void PAGI\CallerId\ICallerId::setNumber(string $value)

Sets caller id number. CALLERID(num)



* Visibility: **public**


#### Arguments
* $value **string** - &lt;p&gt;Number.&lt;/p&gt;



### setCallerPres

    void PAGI\CallerId\ICallerId::setCallerPres(string $presentationMode)

Changes the caller id presentation mode.



* Visibility: **public**


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


