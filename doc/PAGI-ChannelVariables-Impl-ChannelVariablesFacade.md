PAGI\ChannelVariables\Impl\ChannelVariablesFacade
===============

ChannelVariables facade implementation.

PHP Version 5


* Class name: ChannelVariablesFacade
* Namespace: PAGI\ChannelVariables\Impl
* This class implements: [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




Properties
----------


### $variables

    private array<mixed,string> $variables

Channel variables given by asterisk.



* Visibility: **private**


### $arguments

    private array<mixed,string> $arguments

AGI Arguments (agi_arg_N).



* Visibility: **private**


Methods
-------


### getAGIVariable

    string PAGI\ChannelVariables\Impl\ChannelVariablesFacade::getAGIVariable(string $key)

Returns the given variable. Returns false if not set.



* Visibility: **protected**


#### Arguments
* $key **string** - &lt;p&gt;Variable to get.&lt;/p&gt;



### getChannel

    string PAGI\ChannelVariables\IChannelVariables::getChannel()

Returns channel (agi_channel).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getLanguage

    string PAGI\ChannelVariables\IChannelVariables::getLanguage()

Returns language (agi_language).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getType

    string PAGI\ChannelVariables\IChannelVariables::getType()

Returns channel type (agi_type).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getUniqueId

    string PAGI\ChannelVariables\IChannelVariables::getUniqueId()

Returns channel uniqueid (agi_uniqueid).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getVersion

    string PAGI\ChannelVariables\IChannelVariables::getVersion()

Returns asterisk version (agi_version).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getCallerId

    string PAGI\ChannelVariables\IChannelVariables::getCallerId()

Returns caller id number (agi_callerid).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getCallerIdName

    string PAGI\ChannelVariables\IChannelVariables::getCallerIdName()

Returns caller id name (agi_calleridname).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getCallingPres

    string PAGI\ChannelVariables\IChannelVariables::getCallingPres()

Returns CallingPres (agi_callingpres).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getCallingAni2

    string PAGI\ChannelVariables\IChannelVariables::getCallingAni2()

Returns CallingAni (agi_callingani2).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getCallingTon

    string PAGI\ChannelVariables\IChannelVariables::getCallingTon()

Returns CallingTon (agi_callington).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getCallingTns

    string PAGI\ChannelVariables\IChannelVariables::getCallingTns()

Returns CallingTns (agi_callingtns).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDNID

    string PAGI\ChannelVariables\IChannelVariables::getDNID()

Returns DNID (agi_dnid).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getContext

    string PAGI\ChannelVariables\IChannelVariables::getContext()

Returns context (agi_context).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getRDNIS

    string PAGI\ChannelVariables\IChannelVariables::getRDNIS()

Returns RDNIS (agi_rdnis).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getRequest

    string PAGI\ChannelVariables\IChannelVariables::getRequest()

Returns agi requested (agi_request).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDNIS

    string PAGI\ChannelVariables\IChannelVariables::getDNIS()

Returns extension dialed (dnis) (agi_extension).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getThreadId

    string PAGI\ChannelVariables\IChannelVariables::getThreadId()

Returns thread id (agi_threadid).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getAccountCode

    string PAGI\ChannelVariables\IChannelVariables::getAccountCode()

Returns account code (agi_accountcode).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getEnhanced

    string PAGI\ChannelVariables\IChannelVariables::getEnhanced()

Returns if using enhanced (agi_enhanced).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getPriority

    string PAGI\ChannelVariables\IChannelVariables::getPriority()

Returns context priority (agi_priority).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getTotalArguments

    integer PAGI\ChannelVariables\IChannelVariables::getTotalArguments()

Returns total number of agi arguments.



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getArgument

    string PAGI\ChannelVariables\IChannelVariables::getArgument(integer $index)

Returns the given agi argument. (agi_arg_N).



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)


#### Arguments
* $index **integer** - &lt;p&gt;Argument number, starting with 0.&lt;/p&gt;



### getArguments

    array<mixed,string> PAGI\ChannelVariables\IChannelVariables::getArguments()

Returns all arguments as an array.



* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryConfig

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryConfig()

Returns the config directory for this running version of asterisk.

Uses environment variable AST_CONFIG_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getConfigFile

    string PAGI\ChannelVariables\IChannelVariables::getConfigFile()

Returns the config file for this running version of asterisk.

Uses environment variable AST_CONFIG_FILE.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryModules

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryModules()

Returns the modules directory for this running version of asterisk.

Uses environment variable AST_MODULE_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectorySpool

    string PAGI\ChannelVariables\IChannelVariables::getDirectorySpool()

Returns the spool directory for this running version of asterisk.

Uses environment variable AST_SPOOL_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryMonitor

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryMonitor()

Returns the monitor directory for this running version of asterisk.

Uses environment variable AST_MONITOR_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryVar

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryVar()

Returns the var directory for this running version of asterisk.

Uses environment variable AST_VAR_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryData

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryData()

Returns the data directory for this running version of asterisk.

Uses environment variable AST_DATA_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryLog

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryLog()

Returns the log directory for this running version of asterisk.

Uses environment variable AST_LOG_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryAgi

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryAgi()

Returns the agi directory for this running version of asterisk.

Uses environment variable AST_AGI_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryKey

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryKey()

Returns the key directory for this running version of asterisk.

Uses environment variable AST_KEY_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### getDirectoryRun

    string PAGI\ChannelVariables\IChannelVariables::getDirectoryRun()

Returns the run directory for this running version of asterisk.

Uses environment variable AST_RUN_DIR.

* Visibility: **public**
* This method is defined by [PAGI\ChannelVariables\IChannelVariables](PAGI-ChannelVariables-IChannelVariables.md)




### __construct

    void PAGI\ChannelVariables\Impl\ChannelVariablesFacade::__construct(array<mixed,string> $variables, array<mixed,string> $arguments)

Constructor.



* Visibility: **public**


#### Arguments
* $variables **array&lt;mixed,string&gt;** - &lt;p&gt;Initial channel variables given by asterisk.&lt;/p&gt;
* $arguments **array&lt;mixed,string&gt;** - &lt;p&gt;AGI arguments given by asterisk (agi_arg_N).&lt;/p&gt;


