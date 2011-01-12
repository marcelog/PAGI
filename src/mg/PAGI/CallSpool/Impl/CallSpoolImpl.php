<?php
/**
 * An implementation for asterisk call spool.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    CallSpool
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
namespace PAGI\CallSpool\Impl;

use PAGI\CallSpool\ICallSpool;
use PAGI\CallSpool\CallFile;
use PAGI\CallSpool\Exception\CallSpoolException;

/**
 * An implementation for asterisk call spool.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    CallSpool
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
class CallSpoolImpl implements ICallSpool
{
    /**
     * Where to temporary generate call files.
     * @var string
     */
    private $_tmpDir = '/tmp';

    /**
     * Asterisk spool directory.
     * @var string
     */
    private $_spoolDir = '/var/spool/asterisk';

    /**
     * Current instance.
     * @var CallSpoolImpl
     */
    private static $_instance = false;

    /**
     * Returns an instance for this spool/
	 *
     * @param string[] $options Configuration options.
     *
     * @return CallSpoolImpl
     */
    public static function getInstance(array $options = array())
    {
        if (self::$_instance === false) {
            $ret = new CallSpoolImpl($options);
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return self::$_instance;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\CallSpool.ICallSpool::spool()
     */
    public function spool(CallFile $call, $schedule = false)
    {
        $filename = tempnam($this->_tmpDir, 'PAGICallFile');
        if ($filename === false) {
            throw new CallSpoolException('Could generate temporary filename');
        }
        if (@file_put_contents($filename, $call->serialize()) === false) {
            @unlink($filename);
            throw new CallSpoolException('Error writing: ' . $filename);
        }
        if ($schedule !== false) {
            if (@touch($filename, $schedule) === false) {
                @unlink($filename);
                throw new CallSpoolException('Error scheduling: ' . $filename);
            }
        }
        $newFilename = implode(
            DIRECTORY_SEPARATOR,
            array($this->_spoolDir, 'outgoing', basename($filename))
        );
        if (@rename($filename, $newFilename) === false) {
            @unlink($filename);
            throw new CallSpoolException('Error spooling: ' . $newFilename);
        }
    }

    /**
     * Constructor.
     *
     * @param string[] $options Options for this spool.
     *
     * @return void
     */
    private function __construct(array $options)
    {
        if (isset($options['tmpDir'])) {
            $this->_tmpDir = $options['tmpDir'];
        }
        if (isset($options['spoolDir'])) {
            $this->_spoolDir = $options['spoolDir'];
        }
    }
}