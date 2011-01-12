<?php
/**
 * PAGI basic use example. Please see run.sh in this same directory for an
 * example of how to actually run this from your dialplan.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    examples
 * @subpackage quickstart
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
use PAGI\Application\PAGIApplication;
use PAGI\Client\ChannelStatus;
use PAGI\CallSpool\CallFile;
use PAGI\CallSpool\Impl\CallSpoolImpl;

/**
 * PAGI basic use example. Please see run.sh in this same directory for an
 * example of how to actually run this from your dialplan.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    examples
 * @subpackage quickstart
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
class MyPAGIApplication extends PAGIApplication
{
    /**
     * (non-PHPdoc)
     * @see PAGI\Application.PAGIApplication::init()
     */
    public function init()
    {
        $this->log('Init');
        $client = $this->getAgi();
        $client->answer();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Application.PAGIApplication::shutdown()
     */
    public function shutdown()
    {
        try
        {
            $this->log('Shutdown');
            $client = $this->getAgi();
            $client->hangup();
        } catch(\Exception $e) {

        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Application.PAGIApplication::run()
     */
    public function run()
    {
        $this->log('Run');
        $client = $this->getAgi();
        //$client->log($client->faxReceive('/tmp/a.tiff')->__toString());
        //$client->log($client->faxSend('/tmp/a.tiff')->__toString());
        $variables = $client->getChannelVariables();
        $client->log('Config dir: ' . $variables->getDirectoryConfig());
        $client->log('Config file: ' . $variables->getConfigFile());
        $client->log('Module dir: ' . $variables->getDirectoryModules());
        $client->log('Spool dir: ' . $variables->getDirectorySpool());
        $client->log('Monitor dir: ' . $variables->getDirectoryMonitor());
        $client->log('Var dir: ' . $variables->getDirectoryVar());
        $client->log('Data dir: ' . $variables->getDirectoryData());
        $client->log('Log dir: ' . $variables->getDirectoryLog());
        $client->log('Agi dir: ' . $variables->getDirectoryAgi());
        $client->log('Key dir: ' . $variables->getDirectoryKey());
        $client->log('Run dir: ' . $variables->getDirectoryRun());
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

        $spool = CallSpoolImpl::getInstance(
        	array(
        		'tmpDir' => '/tmp/Pagi',
        		'spoolDir' => $variables->getDirectorySpool()
            )
        );

        $result = $client->sayDigits('12345', '12#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for say digits.');
        }

        $result = $client->sayNumber('12345', '12#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for say number.');
        }

        $result = $client->getData('/var/lib/asterisk/sounds/welcome', 10000, 4);
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for get data with: ' . $result->getDigits());
        }

        $result = $client->getOption('/var/lib/asterisk/sounds/welcome', '0123456789*#', 10000);
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for get option.');
        }

        $result = $client->streamFile('/var/lib/asterisk/sounds/welcome', '#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for stream file.');
        }

        $client->log('Channel status: ' . ChannelStatus::toString($client->channelStatus()));
        $client->log('Channel status: ' . ChannelStatus::toString($client->channelStatus($variables->getChannel())));
        $client->log('Variable: ' . $client->getVariable('EXTEN'));
        $client->log('FullVariable: ' . $client->getFullVariable('EXTEN'));
        $cdr = $client->getCDR();
        $client->log('CDRVariable: ' . $cdr->getSource());
        $cdr->setAccountCode('foo');
        $client->log('CDRVariable: ' . $cdr->getAccountCode());

        $callerId = $client->getCallerId();
        $client->log('CallerID: ' . $callerId);
        $callerId->setName('pepe');
        $client->log('CallerID: ' . $callerId);
        $client->setCallerId('foo', '123123');
        $client->log('CallerID: ' . $callerId);

        $client->log($client->exec('Dial', array('SIP/sip', 30, 'r')));
        $client->log($client->dial('SIP/01', array(30, 'r')));

        $result = $client->sayPhonetic('marcelog', '123#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for say phonetic.');
        }

        $result = $client->sayAlpha('marcelog', '123#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for say alpha.');
        }

        $result = $client->sayTime(time(), '123#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for say time.');
        }

        $result = $client->sayDateTime(time(), 'mdYHMS', '123#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for say datetime.');
        }

        $result = $client->sayDate(time(), '123#');
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for say date.');
        }

        $client->setPriority(1000);
        $client->setExtension(1000);
        $client->setContext('foo');
        $client->setMusic(true);
        sleep(10);
        $client->setMusic(false);

        $result = $client->waitDigit(10000);
        if (!$result->isTimeout()) {
            $client->log('Read: ' . $result->getDigits());
        } else {
            $client->log('Timeouted for waitdigit.');
        }
        $result = $client->record('/tmp/asd', 'wav', '#');
        if ($result->isInterrupted()) {
            if ($result->isHangup()) {
                $this->log('hangup when recording.');
            } else {
                $this->log('interrupted with: ' . $result->getDigits());
            }
            $this->log('Recorded: ' . $result->getEndPos());
        }
        $client->streamFile('/tmp/asd', '');
        $callFile = new CallFile();
        $callFile->setChannel('SIP/01');
        $callFile->setContext('campaign');
        $callFile->setExtension('failed');
        $callFile->setVariable('foo', 'bar');
        $callFile->setPriority('1');
        $callFile->setMaxRetries('0');
        $callFile->setWaitTime(10);
        $callFile->setCallerId('some<123123>');

        file_put_contents('/tmp/acallfilesample.call', $callFile->serialize());
        $callFile = new CallFile();
        $callFile->unserialize(file_get_contents('/tmp/acallfilesample.call'));
        $callFile = new CallFile();
        $callFile->setChannel('SIP/01');
        $callFile->setContext('campaign');
        $callFile->setExtension('failed');
        $callFile->setVariable('foo', 'bar');
        $callFile->setPriority('1');
        $callFile->setMaxRetries('0');
        $callFile->setWaitTime(10);
        $callFile->setCallerId('some<123123>');
        $spool->spool($callFile, time() + 30);
        //unlink('/tmp/acallfilesample.call');
        //$client->log($client->databaseGet('SIP', 'Registry'));
        //$client->setAutoHangup(10);
        //sleep(20);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Application.PAGIApplication::errorHandler()
     */
    public function errorHandler($type, $message, $file, $line)
    {
        $this->log(
        	'ErrorHandler: '
            . implode(' ', array($type, $message, $file, $line))
        );
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Application.PAGIApplication::signalHandler()
     */
    public function signalHandler($signal)
    {
        $this->log('SignalHandler got signal: ' . $signal);
    }
}
