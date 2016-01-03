<?php
/**
 * An example using nodes and node controller. This is a part of a calling card
 * prepaid system. The nodes will let you enter a pin number, make a transfer
 * between cards, dial a number, and listen to the help.
 *
 * Sounds are not provided, just the code as a sample of what can be done
 * with the node controller.
 */
use PAGI\Node\NodeController;
use PAGI\Application\PAGIApplication;
use PAGI\Node\Node;

class Card
{
    public function isExpired()
    {
        return false;
    }

    public function isDued()
    {
        return false;
    }

    public function inUse()
    {
        return false;
    }

    public function hasMinimumCredit()
    {
        return true;
    }
}


class MyPagiApplication extends PAGIApplication
{
    protected $agi;
    protected $asteriskLogger;
    protected $channelVariables;
    protected $nodeController;

    protected function getCallingCardValidationsForSecondCard()
    {
        return array_merge(
            $this->getCallingCardValidationsForTransfer(),
            array(
                'card1DifferentFromCard2' => Node::createValidatorInfo(
                    function(Node $node) {
                        $pin1 = $node->getCustomData('pin1');
                        $pin2 = $node->getInput();
                        return $pin1 != $pin2;
                    },
                    'pp/33'
                ),
            )
        );
    }

    protected function getCallingCardValidationsForCall()
    {
        return array_merge(
            $this->getCommonCallingCardValidations(),
            array(
                'cardWithMinimumCreditForCall' => Node::createValidatorInfo(
                    function(Node $node) {
                        $card = $node->getCustomData('myCardEntity');
                        return $card->hasMinimumCredit();
                    },
                    'pp/18'
                ),
            )
        );
    }

    public function getCallingCardValidationsForTransfer()
    {
        return array_merge(
            $this->getCommonCallingCardValidations(),
            array(
                'cardWithMinimumCreditForTransfer' => Node::createValidatorInfo(
                    function(Node $node) {
                        $card = $node->getCustomData('myCardEntity');
                        return $card->hasMinimumCredit();
                    },
                    'pp/32'
                ),
            )
        );
    }
    public function getCommonCallingCardValidations()
    {
        return array(
            'cardExists' => Node::createValidatorInfo(
                function(Node $node) {
                    $node->saveCustomData('myCardEntity', new Card);
                    return true;
                },
                'pp/11'
            ),
            'cardIsNotExpired' => Node::createValidatorInfo(
                function(Node $node) {
                    $card = $node->getCustomData('myCardEntity');
                    return !$card->isExpired();
                },
                'pp/12'
            ),
            'cardIsNotDued' => Node::createValidatorInfo(
                function(Node $node) {
                    $card = $node->getCustomData('myCardEntity');
                    return !$card->isDued();
                },
                'pp/15'
            ),
            'cardIsNotInUse' => Node::createValidatorInfo(
                function(Node $node) {
                    $card = $node->getCustomData('myCardEntity');
                    return !$card->inUse();
                },
                'pp/34'
            )
        );
    }

    protected function buildGenericNode($name, NodeController $nodeController)
    {
        return $nodeController->register($name)
            ->maxTotalTimeForInput(50000)
            ->maxTimeBetweenDigits(3000)
        ;
    }

    protected function buildMaxAttemptsReached(NodeController $nodeController)
    {
        $this->buildGenericNode('maxAttemptsReached', $nodeController)
            ->saySound('pp/5')
        ;
        $nodeController->registerResult('maxAttemptsReached')
            ->onComplete()
            ->hangup(16)
        ;
    }

    protected function buildHelp(NodeController $nodeController)
    {
        $this->buildGenericNode('help', $nodeController)
            ->saySound('pp/43')
        ;
        $nodeController->registerResult('help')
            ->onComplete()
            ->jumpTo('mainMenu')
        ;
    }

    protected function buildPinEntry(
        $name, $sound, $nextNodeName,
        NodeController $nodeController, $validators,
        $onInit = null
    ) {
        $node = $this->buildGenericNode($name, $nodeController)
            ->saySound($sound)
            ->expectAtLeast(1)
            ->expectAtMost(12)
            ->cancelWith(Node::DTMF_STAR)
            ->endInputWith(Node::DTMF_HASH)
            ->maxAttemptsForInput(3)
            ->loadValidatorsFrom($validators)
        ;
        if ($onInit !== null) {
            $node->executeBeforeRun($onInit);
        }
        $nodeController->registerResult($name)
            ->onComplete()
            ->jumpTo($nextNodeName)
        ;
        $nodeController->registerResult($name)
            ->onCancel()
            ->jumpTo('mainMenu')
        ;
        return $node;
    }

    protected function buildMainMenu(NodeController $nodeController)
    {
        $this->buildGenericNode('mainMenu', $nodeController)
            ->saySound('pp/3')
            ->maxAttemptsForInput(3)
            ->endInputWith(Node::DTMF_HASH)
            ->playOnNoInput('pp/6')
            ->expectExactly(1)
            ->validateInputWith(
                'option',
                function(Node $node) {
                    return in_array(
                        $node->getInput(), array('1', '2', '3', '9')
                    );
                },
                'pp/50'
            )
        ;
        $nodeController->registerResult('mainMenu')
            ->onMaxAttemptsReached()
            ->jumpTo('maxAttemptsReached')
        ;

        $nodeController->registerResult('mainMenu')
            ->onComplete()
            ->withInput('1')
            ->jumpTo('inputPinForCall')
        ;
        $nodeController->registerResult('mainMenu')
            ->onComplete()
            ->withInput('2')
            ->jumpTo('inputPinForPlayBalance')
        ;
        $nodeController->registerResult('mainMenu')
            ->onComplete()
            ->withInput('3')
            ->jumpTo('inputPinForTransfer')
        ;
        $nodeController->registerResult('mainMenu')
            ->onComplete()
            ->withInput('9')
            ->jumpTo('help')
        ;
    }

    protected function buildPlayBalance(NodeController $nodeController)
    {
        $this->buildGenericNode('playBalance', $nodeController)
            ->saySound('pp/22')
            ->sayNumber('55')
            ->saySound('pp/23')
            ->saySound('pp/25')
            ->sayNumber('38')
            ->saySound('pp/24')
            ->saySound('pp/26')
            ->sayNumber('2')
            ->saySound('pp/23')
            ->saySound('pp/25')
            ->sayNumber('4')
            ->saySound('pp/24')
        ;
        $nodeController->registerResult('playBalance')
            ->onComplete()
            ->jumpTo('mainMenu')
        ;
    }

    protected function buildConfirmTransferToCard(
        NodeController $nodeController, \Closure $onInit
    ) {
        $this->buildGenericNode('confirmTransferToCard', $nodeController)
            ->cancelWith(Node::DTMF_STAR)
            ->saySound('pp/31')
            ->expectExactly(1)
            ->validateInputWith(
            	'option',
                function (Node $node) {
                    return $node->getInput() == 1;
                },
                array('pp/4', 'pp/50')
            )
            ->maxAttemptsForInput(3)
            ->executeBeforeRun($onInit)
        ;
        $nodeController->registerResult('confirmTransferToCard')
            ->onCancel()
            ->jumpTo('mainMenu')
        ;
        $nodeController->registerResult('confirmTransferToCard')
            ->onMaxAttemptsReached()
            ->jumpTo('maxAttemptsReached')
        ;
        $nodeController->registerResult('confirmTransferToCard')
            ->onComplete()
            ->jumpTo('playBalance')
        ;
    }

    protected function buildDial(NodeController $nodeController)
    {
        $this->buildGenericNode('dial', $nodeController)
            ->saySound('pp/16')
            ->maxAttemptsForInput(3)
            ->expectAtLeast(1)
            ->expectAtMost(15)
            ->cancelWith(Node::DTMF_STAR)
            ->cancelWithInputRetriesInput()
        ;
        $nodeController->registerResult('dial')
            ->onCancel()
            ->jumpTo('mainMenu')
        ;
    }
    public function run()
    {
        $this->agi->answer();
        $this->nodeController->jumpTo('mainMenu');
    }

    public function init()
    {
        $this->logger->info('Init');
        $this->agi = $this->getAgi();
        $this->asteriskLogger = $this->agi->getAsteriskLogger();
        $this->channelVariables = $this->agi->getChannelVariables();
        $this->asteriskLogger->notice('Init');
        $this->nodeController = $this->agi->createNodeController('app');
        $this->buildHelp($this->nodeController);
        $this->buildDial($this->nodeController);
        $this->buildMainMenu($this->nodeController);
        $this->buildMaxAttemptsReached($this->nodeController);
        $this->buildPlayBalance($this->nodeController);
        $this->buildPinEntry(
        	'inputPinForPlayBalance', 'pp/8', 'playBalance',
            $this->nodeController, $this->getCommonCallingCardValidations()
        );
        $nodeTransfer1stCard = $this->buildPinEntry(
        	'inputPinForTransfer', 'pp/38', 'inputPinForTransfer2ndCard',
            $this->nodeController, $this->getCallingCardValidationsForTransfer()
        );
        $nodeTransfer2ndCard = $this->buildPinEntry(
        	'inputPinForTransfer2ndCard', 'pp/39', 'confirmTransferToCard',
            $this->nodeController,
            $this->getCallingCardValidationsForSecondCard(),
            function (Node $node) use ($nodeTransfer1stCard) {
                $node->saveCustomData('pin1', $nodeTransfer1stCard->getInput());
            }
        );
        $this->buildPinEntry(
        	'inputPinForCall', 'pp/8', 'dial', $this->nodeController,
            $this->getCallingCardValidationsForCall()
        );
        $this->buildConfirmTransferToCard(
            $this->nodeController,
            function (Node $node) use ($nodeTransfer1stCard, $nodeTransfer2ndCard) {
                $node->saveCustomData('pin1', $nodeTransfer1stCard->getInput());
                $node->saveCustomData('pin2', $nodeTransfer2ndCard->getInput());
            }
        );
    }

    public function signalHandler($signo)
    {
        $this->asteriskLogger->notice("Got signal: $signo");
        $this->logger->info("Got signal: $signo");
        exit(0);
    }

    public function errorHandler($type, $message, $file, $line)
    {
        $this->asteriskLogger->error("$message at $file:$line");
        $this->logger->error("$message at $file:$line");
    }

    public function shutdown()
    {
        $this->asteriskLogger->notice('Shutdown');
    }
}

