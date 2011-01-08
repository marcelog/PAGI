<?php
/**
 * PAGI basic use example.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
// Setup include path.
ini_set(
    'include_path',
    implode(
        PATH_SEPARATOR,
        array(
            ini_get('include_path'),
            implode(DIRECTORY_SEPARATOR, array('..', '..', '..', 'src', 'mg'))
        )
    )
);

////////////////////////////////////////////////////////////////////////////////
// Mandatory stuff to bootstrap.
////////////////////////////////////////////////////////////////////////////////
require_once 'PAGI/Autoloader/Autoloader.php'; // Include ding autoloader.
Autoloader::register(); // Call autoloader register for ding autoloader.
use PAGI\Client\Impl\ClientImpl;

$loggerConfig = realpath('./log4php.properties');
$client = ClientImpl::getInstance(array('log4php.properties' => $loggerConfig));

try
{
    $variables = $client->getClientVariables();
    $client->log('Request: '. $variables->getRequest());
    $client->log('Channel: '. $variables->getChannel());
    $client->log('Language: '. $variables->getLanguage());
    $client->log('Type: '. $variables->getType());
    $client->log('UniqueId: ' . $variables->getUniqueId());
    $client->log('Version: ' . $variables->getVersion());
    $client->log('CallerId: ' . $variables->getCallerId());
    $client->log('CallerId name: ' . $variables->getCallerIdName());
    $client->log('CallerId pres: ' . $variables->getCallingPres());
    $client->log('CallingAni2: ' . $variables->getCallingAni2());
    $client->log('CallingTon: ' . $variables->getCallingTon());
    $client->log('CallingTNS: ' . $variables->getCallingTns());
    $client->log('DNID: ' . $variables->getDNID());
    $client->log('RDNIS: ' . $variables->getRDNIS());
    $client->log('Context: ' . $variables->getContext());
    $client->log('Extension: ' . $variables->getDNIS());
    $client->log('Priority: ' . $variables->getPriority());
    $client->log('Enhanced: ' . $variables->getEnhanced());
    $client->log('AccountCode: ' . $variables->getAccountCode());
    $client->log('ThreadId: ' . $variables->getThreadId());
    $client->log('Arguments: ' . intval($variables->getTotalArguments()));
    for ($i = 0; $i < $variables->getTotalArguments(); $i++) {
        $client->log(' -- Argument ' . intval($i) . ': ' . $variables->getArgument($i));
    }
    $client->answer();
    $int = false;
    $digit = false;
    $client->sayDigits('123123123', '12#', $int, $digit);
    if ($int) {
        $client->log('Interrupted with: ' . $digit);
    }
} catch (\Exception $e) {
    $client->log('Exception caught: ' . $e);
}