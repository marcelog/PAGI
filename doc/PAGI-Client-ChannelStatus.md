PAGI\Client\ChannelStatus
===============

ChannelStatus &#039;Helper&#039;. See: http://www.voip-info.org/wiki/view/channel+status

PHP Version 5


* Class name: ChannelStatus
* Namespace: PAGI\Client



Constants
----------


### DOWN_AVAILABLE

    const DOWN_AVAILABLE = 0





### DOWN_RESERVED

    const DOWN_RESERVED = 1





### OFF_HOOK

    const OFF_HOOK = 2





### DIGITS_DIALED

    const DIGITS_DIALED = 3





### LINE_RINGING

    const LINE_RINGING = 4





### REMOTE_RINGING

    const REMOTE_RINGING = 5





### LINE_UP

    const LINE_UP = 6





### LINE_BUSY

    const LINE_BUSY = 7







Methods
-------


### toString

    string PAGI\Client\ChannelStatus::toString(integer $status)

This will return the human readable description for the given channel
status. See class constants. (False if the status is invalid).



* Visibility: **public**
* This method is **static**.


#### Arguments
* $status **integer** - &lt;p&gt;Channel status.&lt;/p&gt;


