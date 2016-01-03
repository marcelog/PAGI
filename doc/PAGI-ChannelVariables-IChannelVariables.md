PAGI\ChannelVariables\IChannelVariables
===============

ChannelVariables facade. Use this to access channel variables.

PHP Version 5


* Interface name: IChannelVariables
* Namespace: PAGI\ChannelVariables
* This is an **interface**






Methods
-------


### getChannel

    string PAGI\ChannelVariables\IChannelVariables::getChannel()

Returns channel (agi_channel).



* Visibility: **public**




### getLanguage

    string PAGI\ChannelVariables\IChannelVariables::getLanguage()

Returns language (agi_language).



* Visibility: **public**




### getType

    string PAGI\ChannelVariables\IChannelVariables::getType()

Returns channel type (agi_type).



* Visibility: **public**




### getUniqueId

    string PAGI\ChannelVariables\IChannelVariables::getUniqueId()

Returns channel uniqueid (agi_uniqueid).



* Visibility: **public**




### getVersion

    string PAGI\ChannelVariables\IChannelVariables::getVersion()

Returns asterisk version (agi_version).



* Visibility: **public**




### getCallerId

    string PAGI\ChannelVariables\IChannelVariables::getCallerId()

Returns caller id number (agi_callerid).



* Visibility: **public**




### getCallerIdName

    string PAGI\ChannelVariables\IChannelVariables::getCallerIdName()

Returns caller id name (agi_calleridname).



* Visibility: **public**




### getCallingPres

    string PAGI\ChannelVariables\IChannelVariables::getCallingPres()

Returns CallingPres (agi_callingpres).



* Visibility: **public**




### getCallingAni2

    string PAGI\ChannelVariables\IChannelVariables::getCallingAni2()

Returns CallingAni (agi_callingani2).



* Visibility: **public**




### getCallingTon

    string PAGI\ChannelVariables\IChannelVariables::getCallingTon()

Returns CallingTon (agi_callington).



* Visibility: **public**




### getCallingTns

    string PAGI\ChannelVariables\IChannelVariables::getCallingTns()

Returns CallingTns (agi_callingtns).



* Visibility: **public**




### getDNID

    string PAGI\ChannelVariables\IChannelVariables::getDNID()

Returns DNID (agi_dnid).



* Visibility: **public**




### getContext

    string PAGI\ChannelVariables\IChannelVariables::getContext()

Returns context (agi_context).



* Visibility: **public**




### getRDNIS

    string PAGI\ChannelVariables\IChannelVariables::getRDNIS()

Returns RDNIS (agi_rdnis).



* Visibility: **public**




### getRequest

    string PAGI\ChannelVariables\IChannelVariables::getRequest()

Returns agi requested (agi_request).



* Visibility: **public**




### getDNIS

    string PAGI\ChannelVariables\IChannelVariables::getDNIS()

Returns extension dialed (dnis) (agi_extension).



* Visibility: **public**




### getThreadId

    string PAGI\ChannelVariables\IChannelVariables::getThreadId()

Returns thread id (agi_threadid).



* Visibility: **public**




### getAccountCode

    string PAGI\ChannelVariables\IChannelVariables::getAccountCode()

Returns account code (agi_accountcode).



* Visibility: **public**




### getEnhanced

    string PAGI\ChannelVariables\IChannelVariables::getEnhanced()

Returns if using enhanced (agi_enhanced).



* Visibility: **public**




### getPriority

    string PAGI\ChannelVariables\IChannelVariables::getPriority()

Returns context priority (agi_priority).



* Visibility: **public**




### getTotalArguments

    integer PAGI\ChannelVariables\IChannelVariables::getTotalArguments()

Returns total number of agi arguments.



* Visibility: **public**




### getArgument

    string PAGI\ChannelVariables\IChannelVariables::getArgument(integer $index)

Returns the given agi argument. (agi_arg_N).



* Visibility: **public**


#### Arguments
* $index **integer** - &lt;p&gt;Argument number, starting with 0.&lt;/p&gt;



### getArguments

    array<mixed,string> PAGI\ChannelVariables\IChannelVariables::getArguments()

Returns all arguments as an array.



* Visibility: **public**




### getDirectoryConfig

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryConfig()

Returns the config directory for this running version of asterisk.

Uses environment variable AST_CONFIG_DIR.

* Visibility: **public**




### getConfigFile

    string PAGI\ChannelVariables\IChannelVariables::getConfigFile()

Returns the config file for this running version of asterisk.

Uses environment variable AST_CONFIG_FILE.

* Visibility: **public**




### getDirectoryModules

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryModules()

Returns the modules directory for this running version of asterisk.

Uses environment variable AST_MODULE_DIR.

* Visibility: **public**




### getDirectorySpool

    string PAGI\ChannelVariables\IChannelVariables::getDirectorySpool()

Returns the spool directory for this running version of asterisk.

Uses environment variable AST_SPOOL_DIR.

* Visibility: **public**




### getDirectoryMonitor

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryMonitor()

Returns the monitor directory for this running version of asterisk.

Uses environment variable AST_MONITOR_DIR.

* Visibility: **public**




### getDirectoryVar

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryVar()

Returns the var directory for this running version of asterisk.

Uses environment variable AST_VAR_DIR.

* Visibility: **public**




### getDirectoryData

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryData()

Returns the data directory for this running version of asterisk.

Uses environment variable AST_DATA_DIR.

* Visibility: **public**




### getDirectoryLog

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryLog()

Returns the log directory for this running version of asterisk.

Uses environment variable AST_LOG_DIR.

* Visibility: **public**




### getDirectoryAgi

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryAgi()

Returns the agi directory for this running version of asterisk.

Uses environment variable AST_AGI_DIR.

* Visibility: **public**




### getDirectoryKey

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryKey()

Returns the key directory for this running version of asterisk.

Uses environment variable AST_KEY_DIR.

* Visibility: **public**




### getDirectoryRun

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryRun()

Returns the run directory for this running version of asterisk.

Uses environment variable AST_RUN_DIR.

* Visibility: **public**



