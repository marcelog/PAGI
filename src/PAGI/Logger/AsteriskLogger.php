<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Logger;

use PAGI\Client\ClientInterface;

/**
 * Facade to access asterisk logger (see logger.conf in your asterisk
 * installation).
 */
class AsteriskLogger implements AsteriskLoggerInterface
{
    const PRIORIT_ERROR = 'ERROR';
    const PRIORITY_WARNING = 'WARNING';
    const PRIORITY_NOTICE = 'NOTICE';
    const PRIORITY_DEBUG = 'DEBUG';
    const PRIORITY_VERBOSE = 'VERBOSE';
    const PRIORITY_DTMF = 'DTMF';

    /**
     * Holds instance of AGI Client.
     *
     * @var ClientInterface
     */
    private $client = false;

    /**
     * The singleton instance
     *
     * @var AsteriskLogger
     */
    private static $instance = null;

    /**
     * Returns the singleton instance
     *
     * @param ClientInterface $client AGI client
     *
     * @return Client
     */
    public static function getInstance(ClientInterface $client)
    {
        if (null === self::$instance) {
            self::$instance = new self($client);
        }

        return self::$instance;
    }

    /**
     * Constructor.
     *
     * @param ClientInterface $client AGI client
     */
    protected function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function error($message)
    {
        $this->client->log($message, self::PRIORIT_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    public function warn($message)
    {
        $this->client->log($message, self::PRIORIT_WARNING);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message)
    {
        $this->client->log($message, self::PRIORIT_NOTICE);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message)
    {
        $this->client->log($message, self::PRIORIT_DEBUG);
    }

    /**
     * {@inheritdoc}
     */
    public function verbose($message)
    {
        $this->client->log($message, self::PRIORIT_VERBOSE);
    }

    /**
     * {@inheritdoc}
     */
    public function dtmf($message)
    {
        $this->client->log($message, self::PRIORIT_DTMF);
    }
}
