<?php
/**
 * An AGI client implementation.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/PAGI/
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
namespace PAGI\Client\Impl;

use PAGI\Client\AbstractClient;
use PAGI\Exception\PAGIException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * An AGI client implementation.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class ClientImpl extends AbstractClient
{
    /**
     * Current instance.
     * @var ClientImpl
     */
    private static $instance = false;

    /**
     * AGI input
     * @var stream
     */
    private $input;

    /**
     * AGI output
     * @var stream
     */
    private $output;

    /**
     * Sends a command to asterisk. Returns an array with:
     * [0] => AGI Result (3 digits)
     * [1] => Command result
     * [2] => Result data.
     *
     * @param string $text Command
     *
     * @throws ChannelDownException
     * @throws InvalidCommandException
     *
     * @return Result
     */
    protected function send($text)
    {
        $this->logger->debug('Sending: ' . $text);
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
     *
     * @return void
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
        }
        while (true) {
            $line = $this->read($this->input);
            if ($this->isEndOfEnvironmentVariables($line)) {
                break;
            }
            $this->readEnvironmentVariable($line);
        }
        $this->logger->debug(print_r($this->variables, true));
    }

    /**
     * Closes the connection to agi.
     *
     * @return void
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
     * @throws PAGIException
     *
     * @return string
     */
    protected function read()
    {
        $line = fgets($this->input);
        if ($line === false) {
            throw new PAGIException('Could not read from AGI');
        }
        $line = substr($line, 0, -1);
        $this->logger->debug('Read: ' . $line);
        return $line;
    }

    /**
     * Returns a client instance for this call.
     *
     * @param array $options Optional properties.
     *
     * @return ClientImpl
     */
    public static function getInstance(array $options = array())
    {
        if (self::$instance === false) {
            $ret = new ClientImpl($options);
            self::$instance = $ret;
        } else {
            $ret = self::$instance;
        }
        return $ret;
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
     * @param array $options Optional properties.
     *
     * @return void
     */
    protected function __construct(array $options = array())
    {
        $this->options = $options;
        $this->logger = new NullLogger;
        $this->open();
    }
}
