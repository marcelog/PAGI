<?php
/**
 * Spooling calls exmaples.
 *
 * PHP Version 5.3
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

ini_set('include_path', implode(PATH_SEPARATOR, array(
    realpath(__DIR__ .'/../../../src/mg'),
    ini_get('include_path')
)));
require_once 'PAGI/Autoloader/PAGI_Autoloader.php'; // Include PAGI autoloader.
PAGI_Autoloader::register(); // Call autoloader register for PAGI autoloader.

use PAGI\CallSpool\CallFile;
use PAGI\CallSpool\Impl\CallSpoolImpl;
use PAGI\DialDescriptor\SIPDialDescriptor;
use PAGI\DialDescriptor\DAHDIDialDescriptor;

$dialDescriptor = new DAHDIDialDescriptor('1949890333', 1);
$callFile = new CallFile($dialDescriptor);
$callFile->setContext('campaign');
$callFile->setExtension('failed');
$callFile->setVariable('foo', 'bar');
$callFile->setPriority('1');
$callFile->setMaxRetries('0');
$callFile->setWaitTime(10);
$callFile->setCallerId('some<123123>');

echo "Call file generated (DAHDI dial descriptor):\n";
echo $callFile->serialize();
echo "\n\n";

$dialDescriptor = new SIPDialDescriptor('24');
$dialDescriptor->setProvider('example.com');

$callFile = new CallFile($dialDescriptor);
$callFile->setContext('default');
$callFile->setExtension('777');
$callFile->setVariable('foo', 'bar');
$callFile->setPriority('1');
$callFile->setMaxRetries('0');
$callFile->setWaitTime(10);
$callFile->setCallerId('some<123123>');

echo "Call file generated (SIP dial descriptor):\n";
echo $callFile->serialize();
echo "\n\n\n";

echo "Spooling generated SIP call\n";
$spool = CallSpoolImpl::getInstance(
    array(
        'tmpDir' => '/tmp',
        'spoolDir' => '/tmp/spoolExample'
    )
);

$spool->spool($callFile);

echo "Spooling generated SIP call to run in 30 seconds\n";
$spool->spool($callFile, time() + 30);
