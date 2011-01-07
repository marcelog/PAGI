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

$client = ClientImpl::getInstance();

try
{
    $client->log('Request: '. $client->getRequest());
    $client->log('Channel: '. $client->getChannel());
    $client->log('Language: '. $client->getLanguage());
    $client->log('Type: '. $client->getType());
    $client->log('UniqueId: ' . $client->getUniqueId());
    $client->log('Version: ' . $client->getVersion());
    $client->log('CallerId: ' . $client->getCallerId());
    $client->log('CallerId name: ' . $client->getCallerIdName());
    $client->log('CallerId pres: ' . $client->getCallingPres());
    $client->log('CallingAni2: ' . $client->getCallingAni2());
    $client->log('CallingTon: ' . $client->getCallingTon());
    $client->log('CallingTNS: ' . $client->getCallingTns());
    $client->log('DNID: ' . $client->getDNID());
    $client->log('RDNIS: ' . $client->getRDNIS());
    $client->log('Context: ' . $client->getContext());
    $client->log('Extension: ' . $client->getDNIS());
    $client->log('Priority: ' . $client->getPriority());
    $client->log('Enhanced: ' . $client->getEnhanced());
    $client->log('AccountCode: ' . $client->getAccountCode());
    $client->log('ThreadId: ' . $client->getThreadId());
    $client->answer();
    $int = false;
    $digit = false;
    $client->sayDigits('123123123', '#', $int, $digit);
    if ($int) {
        $client->log('Interrupted with: ' . $digit);
    }
} catch (\Exception $e) {
    $client->log('Exception caught: ' . $e->getMessage());
}