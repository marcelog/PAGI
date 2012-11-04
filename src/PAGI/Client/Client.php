<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Client;

use PAGI\Exception\PAGIException;

/**
 * An AGI client implementation.
 */
class Client extends AbstractClient
{
    /**
     * AGI input
     *
     * @var stream
     */
    private $input;

    /**
     * AGI output
     *
     * @var stream
     */
    private $output;

    /**
     * The singleton instance
     *
     * @var Client
     */
    private static $instance = null;

    /**
     * Returns the singleton instance
     *
     * @param array $options Optional properties.
     *
     * @return Client
     */
    public static function getInstance(array $options = array())
    {
        if (null === self::$instance) {
            self::$instance = new self($options);
        }

        return self::$instance;
    }

    /**
     * Constructor.
     *
     * Note: The client accepts an array with options. The available options are
     *
     * stdin => Optional. If set, should contain an already open stream from
     * where the client will read data (useful to make it interact with fastagi
     * servers or even text files to mock stuff when testing). If not set, stdin
     * will be used by the client.
     *
     * stdout => Optional. Same as stdin but for the output of the client.
     *
     * @param array $options Optional properties
     */
    protected function __construct(array $options = array())
    {
        $this->options = $options;
        $this->open();
    }

    /**
     * Sends a command to asterisk. Returns an array with:
     * [0] => AGI Result (3 digits)
     * [1] => Command result
     * [2] => Result data.
     *
     * @param string $text Command
     *
     * @return \PAGI\Client\Result\Result
     *
     * @throws PAGIException
     * @throws \PAGI\Exception\ChannelDownException
     * @throws \PAGI\Exception\InvalidCommandException
     */
    protected function send($text)
    {
        $text .= "\n";
        $len = strlen($text);
        $res = fwrite($this->output, $text) === $len;

        if ($res != true) {
            throw new PAGIException('Could not send command, fwrite failed');
        }

        do {
            $res = $this->read();
        } while (strlen($res) < 2);

        return $this->getResultFromResultString($res);
    }

    /**
     * Opens connection to agi. Will also read initial channel variables given
     * by asterisk when launching the agi.
     */
    protected function open()
    {
        if (isset($this->options['stdin'])) {
            $this->input = $this->options['stdin'];
        } else {
            $this->input = fopen('php://stdin', 'r');
        }

        if (isset($this->options['stdout'])) {
            $this->output = $this->options['stdout'];
        } else {
            $this->output = fopen('php://stdout', 'w');
        } while (true) {
            $line = $this->read($this->input);
            if ($this->isEndOfEnvironmentVariables($line)) {
                break;
            }
            $this->readEnvironmentVariable($line);
        }
    }

    /**
     * Closes the connection to agi.
     */
    protected function close()
    {
        if ($this->input !== false) {
            fclose($this->input);
        }

        if ($this->output !== false) {
            fclose($this->output);
        }
    }

    /**
     * Reads input from asterisk.
     *
     * @return string
     *
     * @throws PAGIException
     */
    protected function read()
    {
        $line = fgets($this->input);
        if ($line === false) {
            throw new PAGIException('Could not read from AGI');
        }

        return substr($line, 0, -1);
    }
}
