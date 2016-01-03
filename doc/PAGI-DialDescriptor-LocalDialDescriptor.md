PAGI\DialDescriptor\LocalDialDescriptor
===============

SIP Dial Descriptor class.




* Class name: LocalDialDescriptor
* Namespace: PAGI\DialDescriptor
* Parent class: [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)



Constants
----------


### TECHNOLOGY

    const TECHNOLOGY = 'LOCAL'





Properties
----------


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

    mixed PAGI\DialDescriptor\LocalDialDescriptor::__construct(string $context, string $extension)

constructor.



* Visibility: **public**


#### Arguments
* $context **string** - &lt;p&gt;The asterisk context&lt;/p&gt;
* $extension **string** - &lt;p&gt;The asterisk extension&lt;/p&gt;



### setTarget

    void PAGI\DialDescriptor\DialDescriptor::setTarget(string $target)

Set dial target.



* Visibility: **public**
* This method is defined by [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)


#### Arguments
* $target **string** - &lt;p&gt;dial target&lt;/p&gt;


