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
        $this->log('Shutdown');
        $client = $this->getAgi();
        $client->hangup();
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Application.PAGIApplication::run()
     */
    public function run()
    {
        $this->log('Run');
        $client = $this->getAgi();
        $variables = $client->getChannelVariables();
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
        $digit = $client->sayDigits('12345', '12#');
        if ($digit !== false) {
            $client->log('Interrupted with: ' . $digit);
        }
        $digit = $client->sayNumber('12345', '12#');
        if ($digit !== false) {
            $client->log('Interrupted with: ' . $digit);
        }

        $digit = $client->getData('/var/lib/asterisk/sounds/welcome', 10000, 4, $int);
        $client->log('Read: ' . $digit . ' ' . ($int ? 'with timeout' : ''));

        $digit = $client->streamFile('/var/lib/asterisk/sounds/welcome', '#');
        $client->log('Played and Read: ' . $digit);
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
        $client->log($client->exec('Dial', array('SIP/sip', 30, 'r')));
        $digit = $client->sayTime(time(), '123#');
        if ($digit !== false) {
            $client->log('Interrupted with: ' . $digit);
        }
        $digit = $client->sayDateTime(time(), 'mdYHMS', '123#');
        if ($digit !== false) {
            $client->log('Interrupted with: ' . $digit);
        }
        $digit = $client->sayDate(time(), '123#');
        if ($digit !== false) {
            $client->log('Interrupted with: ' . $digit);
        }
        $client->setAutoHangup(10);
        $client->setPriority(1000);
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
