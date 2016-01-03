<?php
use PAGI\Application\PAGIApplication;
use PAGI\Node\Node;

class MyPagiApplication extends PAGIApplication
{
    protected $agi;
    protected $asteriskLogger;
    protected $channelVariables;

    public function mainMenu()
    {
        return $this->agi->createNode('mainMenu')
            ->saySound('pp/30')
            ->sayDigits(123)
            ->sayNumber(321)
            ->sayDateTime(1, 'dmY')
            ->unInterruptablePrompts()
            ->maxAttemptsForInput(1)
            ->endInputWith(Node::DTMF_HASH)
            ->playOnNoInput('pp/6')
            ->expectExactly(1)
            ->playOnMaxValidInputAttempts('pp/5')
            ->maxTotalTimeForInput(50000)
            ->maxTimeBetweenDigits(3000)
            ->validateInputWith(
                'option',
                function(Node $node) {
                    return $node->getInput() < 6 && $node->getInput() > 0;
                },
                'pp/50'
            )->executeOnValidInput(function (Node $node) {
                $node->getClient()->playBusyTone();
                $node->getClient()->streamFile('hi');
            })
        ;
    }

    public function run()
    {
        $this->agi->answer();
        $digits = '';
        $this->mainMenu()->run();
    }

    public function init()
    {
        $this->logger->info('Init');
        $this->agi = $this->getAgi();
        $this->asteriskLogger = $this->agi->getAsteriskLogger();
        $this->channelVariables = $this->agi->getChannelVariables();
        $this->asteriskLogger->notice('Init');
    }

    public function signalHandler($signo)
    {
        $this->asteriskLogger->notice("Got signal: $signo");
        $this->logger->info("Got signal: $signo");
        exit(0);
    }

    public function errorHandler($type, $message, $file, $line)
    {
        $this->logger->error("$message at $file:$line");
    }

    public function shutdown()
    {
        $this->asteriskLogger->notice('Shutdown');
    }
}

