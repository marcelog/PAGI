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
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
namespace PAGI\Client\Impl;

use PAGI\Client\ChannelStatus;

use PAGI\Exception\ExecuteCommandException;
use PAGI\Exception\PAGIException;
use PAGI\Exception\ChannelDownException;
use PAGI\Exception\SoundFileException;
use PAGI\Exception\InvalidCommandException;
use PAGI\Client\IClient;
use PAGI\ChannelVariables\Impl\ChannelVariablesFacade;
use PAGI\CDR\Impl\CDRFacade;
use PAGI\CallerId\Impl\CallerIdFacade;

/**
 * An AGI client implementation.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
 */
class ClientImpl implements IClient
{
    /**
     * Current instance.
     * @var ClientImpl
     */
    private static $_instance = false;

    /**
     * log4php logger or dummy.
     * @var Logger
     */
    private $_logger;

    /**
     * Initial channel variables given by asterisk at start.
     * @var string[]
     */
    private $_variables;

    /**
     * Initial arguments given by the user in the dialplan.
     * @var string[]
     */
    private $_arguments;

    /**
     * AGI input
     * @var stream
     */
    private $_input;

    /**
     * AGI output
     * @var stream
     */
    private $_output;

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
     * @return array
     */
    protected function send($text)
    {
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug('Sending: ' . $text);
        }
        $text .= "\n";
        $len = strlen($text);
        $res = fwrite($this->_output, $text) === $len;
        if ($res != true) {
            return false;
        }
        do {
            $res = $this->read();
        } while(strlen($res) < 2);
        $response = explode(' ', $res);
        $code = $response[0];
        switch($code)
        {
        case 200:
            break;
        case 511:
            throw new ChannelDownException($text . ' - ' . print_r($res, true));
        case 510:
        case 520:
        default:
            throw new InvalidCommandException($text . ' - ' . print_r($res, true));
        }
        $result = '';
        $data = '';

        $result = explode('=', $response[1]);
        if (isset($result[1])) {
            $result = $result[1];
        }

        if (isset($response[2])) {
            unset($response[0]);
            unset($response[1]);
            $data = implode(' ', $response);
        }
        return array('code' => $code, 'result' => $result, 'data' => $data);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::exec()
     */
    public function exec($application, array $options = array())
    {
        $cmd = implode(
        	' ', array(
        		'EXEC', '"' . $application . '"',
        		'"' . implode(',', $options) . '"'
            )
        );
        $result = $this->send($cmd);
        if ($result['result'] == -2) {
            throw new ExecuteCommandException('Failed to execute: ' . $cmd);
        }
        return $result['result'];
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setAutoHangup()
     */
    public function setAutoHangup($time)
    {
        $cmd = implode(
        	' ', array('SET', 'AUTOHANGUP', $time)
        );
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::channelStatus()
     */
    public function channelStatus($channel = false)
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'CHANNEL', 'STATUS',
        		$channel ? '"' . $channel . '"' : ''
        	)
        );
        $result = $this->send($cmd);
        return intval($result['result']);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::streamFile()
     */
    public function streamFile($file, $escapeDigits = '')
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'STREAM', 'FILE',
        		'"' . $file . '"',
        	    '"' . $escapeDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == -1) {
            throw new ChannelDownException('StreamFile failed');
        }
        $data = explode('=', $result['data']);
        if ($data[1] == 0) {
            throw new SoundFileException('Invalid format?');
        }
        if ($result['result'] > 0) {
            return chr($result['result']);
        }
        return false;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getData()
     */
    public function getData($file, $maxTime, $maxDigits, &$timeout = false)
    {
        $timeout = false;
        $digits = false;
        $cmd = implode(
        	' ',
        	array(
        		'GET', 'DATA',
        		'"' . $file . '"',
        	    '"' . $maxTime . '"',
        	    '"' . $maxDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == -1) {
            throw new ChannelDownException('GetData failed');
        }
        $timeout = (strpos($result['data'], '(timeout)') !== false);
        return $result['result'];
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayTime()
     */
    public function sayTime($time, $escapeDigits = '')
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'SAY', 'TIME',
        		'"' . $time . '"',
        	    '"' . $escapeDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        switch($result['result'])
        {
        case -1:
            throw new ChannelDownException('SayTime failed');
            break;
        case 0:
            break;
        default:
            $interrupted = true;
            $digit = chr($result['result']);
            break;
        }
        return $digit;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayDate()
     */
    public function sayDate($time, $escapeDigits = '')
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'SAY', 'DATE',
        		'"' . $time . '"',
        		'"' . $escapeDigits . '"'
            )
        );
        $result = $this->send($cmd);
        switch($result['result'])
        {
        case -1:
            throw new ChannelDownException('SayDate failed');
            break;
        case 0:
            break;
        default:
            $interrupted = true;
            $digit = chr($result['result']);
            break;
        }
        return $digit;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setPriority()
     */
    public function setPriority($priority)
    {
        $cmd = implode(' ', array('SET', 'PRIORITY', '"' . $priority . '"'));
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setExtension()
     */
    public function setExtension($extension)
    {
        $cmd = implode(' ', array('SET', 'EXTENSION', '"' . $extension. '"'));
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setMusic()
     */
    public function setMusic($enable, $class = false)
    {
        $cmd = implode(
        	' ',
        	array(
        		'SET', 'MUSIC',
        	    $enable ? 'on' : 'off',
        	    $class ? '"' . $class . '"' : ''
            )
        );
        $this->send($cmd);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayDateTime()
     */
    public function sayDateTime($time, $format, $escapeDigits = '')
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'SAY', 'DATETIME',
        		'"' . $time . '"',
        		'"' . $escapeDigits . '"',
        		'"' . $format . '"'
            )
        );
        $result = $this->send($cmd);
        switch($result['result'])
        {
        case -1:
            throw new ChannelDownException('SayDateTime failed');
            break;
        case 0:
            break;
        default:
            $interrupted = true;
            $digit = chr($result['result']);
            break;
        }
        return $digit;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayDigits()
     */
    public function sayDigits($digits, $escapeDigits = '')
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'SAY', 'DIGITS',
        		'"' . $digits . '"',
        	    '"' . $escapeDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        switch($result['result'])
        {
        case -1:
            throw new ChannelDownException('SayDigits failed');
            break;
        case 0:
            break;
        default:
            $interrupted = true;
            $digit = chr($result['result']);
            break;
        }
        return $digit;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::sayNumber()
     */
    public function sayNumber($digits, $escapeDigits = '')
    {
        $digit = false;
        $cmd = implode(
        	' ',
        	array(
        		'SAY', 'NUMBER',
        		'"' . $digits . '"',
        	    '"' . $escapeDigits . '"'
        	)
        );
        $result = $this->send($cmd);
        switch($result['result'])
        {
        case -1:
            throw new ChannelDownException('SayNumber failed');
            break;
        case 0:
            break;
        default:
            $digit = chr($result['result']);
            break;
        }
        return $digit;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::answer()
     */
    public function answer()
    {
        $result = $this->send('ANSWER');
        if ($result['result'] == -1) {
            throw new ChannelDownException('Answer failed');
        }
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::hangup()
     */
    public function hangup($channel = false)
    {
        $cmd = implode(
        	' ',
        	array(
        		'HANGUP',
        		$channel ? '"' . $channel . '"' : ''
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == -1) {
            throw new ChannelDownException('Hangup failed');
        }
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getVariable()
     */
    public function getVariable($name)
    {
        $cmd = implode(
        	' ',
        	array(
        		'GET', 'VARIABLE',
        	    '"' . $name . '"'
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == 0) {
            return false;
        }
        return substr($result['data'], 1, -1);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getFullVariable()
     */
    public function getFullVariable($name, $channel = false)
    {
        $cmd = implode(
        	' ',
        	array(
        		'GET', 'FULL', 'VARIABLE',
        	    '"${' . $name . '}"',
        		$channel ? '"' . $channel . '"' : ''
        	)
        );
        $result = $this->send($cmd);
        if ($result['result'] == 0) {
            return false;
        }
        return substr($result['data'], 1, -1);
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::setVariable()
     */
    public function setVariable($name, $value)
    {
        $cmd = implode(
        	' ',
        	array(
        		'SET', 'VARIABLE',
        	    '"' . $name . '"',
        	    '"' . str_replace('"', '\\"', $value) . '"'
        	)
        );
        $result = $this->send($cmd);
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::log()
     */
    public function log($msg)
    {
        $msg = str_replace("\r", '', $msg);
        $msg = explode("\n", $msg);
        foreach ($msg as $line) {
            $this->send('VERBOSE "' . str_replace('"', '\\"', $line) . '" 1');
        }
    }

    /**
     * Opens connection to agi. Will also read initial channel variables given
     * by asterisk when launching the agi.
     *
     * @return void
     */
    protected function open()
    {
        $this->_input = fopen('php://stdin', 'r');
        $this->_output = fopen('php://stdout', 'w');
        $this->_variables = array();
        $this->_arguments = $this->_variables; // Just reusing an empty array.
        while(true) {
            $line = $this->read($this->_input);
            if (strlen($line) < 1) {
                break;
            }
            $variableName = explode(':', substr($line, 4));
            $key = trim($variableName[0]);
            unset($variableName[0]);
            $value = trim(implode('', $variableName));
            if (strncmp($key, 'arg_', 4) === 0) {
                $this->_arguments[] = $value;
            } else {
                $this->_variables[$key] = $value;
            }
        }
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug(print_r($this->_variables, true));
        }
    }

    /**
     * Closes the connection to agi.
     *
     * @return void
     */
    protected function close()
    {
        if ($this->_input !== false) {
            fclose($input);
        }
        if ($this->_output !== false) {
            fclose($output);
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
        $line = fgets($this->_input);
        if ($line === false) {
            throw new PAGIException('Could not read from AGI');
        }
        $line = substr($line, 0, -1);
        if ($this->_logger->isDebugEnabled()) {
            $this->_logger->debug('Read: ' . $line);
        }
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
        if (self::$_instance === false) {
            $ret = new ClientImpl($options);
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }


    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getChannelVariables()
     */
    public function getChannelVariables()
    {
        return ChannelVariablesFacade::getInstance(
            $this->_variables, $this->_arguments
        );
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getCDR()
     */
    public function getCDR()
    {
        return CDRFacade::getInstance($this);
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client.IClient::getCallerId()
     */
    public function getCallerId()
    {
        return CallerIdFacade::getInstance($this);
    }

    /**
     * Constructor.
     *
     * @param array $options Optional properties.
     *
     * @return void
     */
    protected function __construct(array $options)
    {
        $this->_variables = false;
        $this->_input = false;
        $this->_output = false;
        if (isset($options['log4php.properties'])) {
            \Logger::configure($options['log4php.properties']);
        }
        $this->_logger = \Logger::getLogger('Pagi.ClientImpl');
        $this->open();
    }
}