<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\CallSpool;

use PAGI\CallSpool\Exception\CallSpoolException;

/**
 * An implementation for asterisk call spool.
 */
class CallSpool implements CallSpoolInterface
{
    /**
     * Where to temporary generate call files.
     *
     * @var string
     */
    private $tmpDir = '/tmp';

    /**
     * Asterisk spool directory.
     *
     * @var string
     */
    private $spoolDir = '/var/spool/asterisk';

    /**
     * The singleton instance
     *
     * @var CallSpool
     */
    private static $instance = null;

    /**
     * Returns the singleton instance
     *
     * @param array $options Configuration options
     *
     * @return CallSpool
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
     * @param array $options Options for this spool
     */
    private function __construct(array $options)
    {
        if (isset($options['tmpDir'])) {
            $this->tmpDir = $options['tmpDir'];
        }

        if (isset($options['spoolDir'])) {
            $this->spoolDir = $options['spoolDir'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function spool(CallFile $call, $schedule = false)
    {
        $filename = tempnam($this->tmpDir, 'CallFile');
        if ($filename === false) {
            throw new CallSpoolException('Could generate temporary filename');
        }

        if (@file_put_contents($filename, $call->serialize()) === false) {
            @unlink($filename);
            throw new CallSpoolException(sprintf('Error writing: %s', $filename));
        }

        if ($schedule !== false) {
            if (@touch($filename, $schedule) === false) {
                @unlink($filename);
                throw new CallSpoolException(sprintf('Error scheduling: %s', $filename));
            }
        }

        $newFilename = implode(
            DIRECTORY_SEPARATOR,
            array($this->spoolDir, 'outgoing', basename($filename))
        );

        if (@rename($filename, $newFilename) === false) {
            @unlink($filename);
            throw new CallSpoolException(sprintf('Error spooling: %s', $newFilename));
        }

        return $newFilename;
    }
}
