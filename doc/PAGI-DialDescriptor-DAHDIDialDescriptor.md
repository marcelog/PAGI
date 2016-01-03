PAGI\DialDescriptor\DAHDIDialDescriptor
===============

DAHDI Dial Descriptor class.




* Class name: DAHDIDialDescriptor
* Namespace: PAGI\DialDescriptor
* Parent class: [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)



Constants
----------


### TECHNOLOGY

    const TECHNOLOGY = 'DAHDI'





Properties
----------


### $identifier

    protected string $identifier

Channel or group identifier.



* Visibility: **protected**


### $isGroup

    protected boolean $isGroup

Is group identifier.



* Visibility: **protected**


### $descendantOrder

    protected boolean $descendantOrder

In case of dialing via a group, this will use g or G so asterisk selects
the outgoing channel in asc or desc order.



* Visibility: **protected**


### $target

    protected string $target

Target to dial.



* Visibility: **protected**


Methods
-------


### getChannelDescriptor

    string PAGI\DialDescriptor\DialDescriptor::getChannelDescriptor()

Get channel descriptor representation



* Visibility: **public**
* This method is **abstract**.
* This method is defined by [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)




### getTechnology

    string PAGI\DialDescriptor\DialDescriptor::getTechnology()

Get channel technology.



* Visibility: **public**
* This method is **abstract**.
* This method is defined by [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)




### __construct

    mixed PAGI\DialDescriptor\DAHDIDialDescriptor::__construct(string $target, integer $identifier, boolean $isGroup, $descendantOrder)

Class constructor.



* Visibility: **public**


#### Arguments
* $target **string** - &lt;p&gt;dial target&lt;/p&gt;
* $identifier **integer** - &lt;p&gt;channel/group identifier&lt;/p&gt;
* $isGroup **boolean** - &lt;p&gt;whether identifier refs a group&lt;/p&gt;
* $descendantOrder **mixed**



### setGroup

    void PAGI\DialDescriptor\DAHDIDialDescriptor::setGroup(integer $group)

Set group to use.



* Visibility: **public**


#### Arguments
* $group **integer** - &lt;p&gt;group of channels to use&lt;/p&gt;



### setChannel

    void PAGI\DialDescriptor\DAHDIDialDescriptor::setChannel(integer $channel)

Set channel to use.



* Visibility: **public**


#### Arguments
* $channel **integer** - &lt;p&gt;channel to use&lt;/p&gt;



### setTarget

    void PAGI\DialDescriptor\DialDescriptor::setTarget(string $target)

Set dial target.



* Visibility: **public**
* This method is defined by [PAGI\DialDescriptor\DialDescriptor](PAGI-DialDescriptor-DialDescriptor.md)


#### Arguments
* $target **string** - &lt;p&gt;dial target&lt;/p&gt;


