PAGI\DialDescriptor\SIPDialDescriptor
===============

SIP Dial Descriptor class.




* Class name: SIPDialDescriptor
* Namespace: PAGI\DialDescriptor
* Parent class: [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)



Constants
----------


### TECHNOLOGY

    const TECHNOLOGY = 'SIP'





Properties
----------


### $provider

    protected string $provider = null

SIP provider.



* Visibility: **protected**


### $target

    protected string $target

Target to dial.



* Visibility: **protected**


Methods
-------


### getTechnology

    string PAGI\DialDescriptor\DialDescriptor::getTechnology()

Get channel technology.



* Visibility: **public**
* This method is **abstract**.
* This method is defined by [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)




### getChannelDescriptor

    string PAGI\DialDescriptor\DialDescriptor::getChannelDescriptor()

Get channel descriptor representation



* Visibility: **public**
* This method is **abstract**.
* This method is defined by [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)




### __construct

    mixed PAGI\DialDescriptor\SIPDialDescriptor::__construct(string $target, $provider)

Class constructor.



* Visibility: **public**


#### Arguments
* $target **string** - &lt;p&gt;dial target&lt;/p&gt;
* $provider **mixed**



### setProvider

    void PAGI\DialDescriptor\SIPDialDescriptor::setProvider(string $provider)

Set SIP provider.



* Visibility: **public**


#### Arguments
* $provider **string** - &lt;p&gt;SIP provider&lt;/p&gt;



### setTarget

    void PAGI\DialDescriptor\DialDescriptor::setTarget(string $target)

Set dial target.



* Visibility: **public**
* This method is defined by [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)


#### Arguments
* $target **string** - &lt;p&gt;dial target&lt;/p&gt;


