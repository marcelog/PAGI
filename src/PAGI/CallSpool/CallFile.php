<?php
/**
 * A call file facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  CallSpool
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/PAGI/
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
namespace PAGI\CallSpool;

use \PAGI\DialDescriptor\DialDescriptor;

/**
 * A call file facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  CallSpool
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
class CallFile
{
    /**
     * Parameters.
     * @var string[]
     */
    private $parameters;

    /**
     * Variables.
     * @var string[]
     */
    private $variables;

    /**
     * Returns the value for the given parameter.
     *
     * @param string $key Parameter name.
     *
     * @return string
     */
    protected function getParameter($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }
        return false;
    }

    /**
     * Sets a given parameter with the given value.
     *
     * @param string $key   Parameter name.
     * @param string $value Value.
     *
     * @return void
     */
    protected function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Returns the value for the given variable.
     *
     * @param string $key Variable name.
     *
     * @return string
     */
    public function getVariable($key)
    {
        if (isset($this->variables[$key])) {
            return $this->variables[$key];
        }
        return false;
    }

    /**
     * Sets a given variable with the given value.
     *
     * @param string $key   Variable name.
     * @param string $value Value.
     *
     * @return void
     */
    public function setVariable($key, $value)
    {
        $this->variables[$key] = $value;
    }

    /**
     * Returns channel to use for the call.
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->getParameter('Channel');
    }

    /**
     * Returns Caller ID, Please note: It may not work if you do not respect
     * the format: CallerID: "Some Name" <1234>
     *
     * @return string
     */
    public function getCallerId()
    {
        return $this->getParameter('CallerID');
    }

    /**
     * Sets the Caller ID, Please note: It may not work if you do not respect
     * the format: CallerID: "Some Name" <1234>
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setCallerId($value)
    {
        $this->setParameter('CallerID', $value);
    }

    /**
     * Returns seconds to wait for an answer. Default is 45.
     *
     * @return integer
     */
    public function getWaitTime()
    {
        return intval($this->getParameter('WaitTime'));
    }

    /**
     * Sets seconds to wait for an answer. Default is 45.
     *
     * @param integer $value Value to set.
     *
     * @return void
     */
    public function setWaitTime($value)
    {
        $this->setParameter('WaitTime', intval($value));
    }

    /**
     * Returns number of retries before failing (not including the initial
     * attempt, e.g. 0 = total of 1 attempt to make the call). Default is 0.
     *
     * @return integer
     */
    public function getMaxRetries()
    {
        return intval($this->getParameter('MaxRetries'));
    }

    /**
     * Sets number of retries before failing (not including the initial
     * attempt, e.g. 0 = total of 1 attempt to make the call). Default is 0.
     *
     * @param integer $value Value to set.
     *
     * @return void
     */
    public function setMaxRetries($value)
    {
        $this->setParameter('MaxRetries', intval($value));
    }

    /**
     * Returns seconds between retries, Don't hammer an unavailable phone.
     * Default is 300 (5 min).
     *
     * @return integer
     */
    public function getRetryTime()
    {
        return intval($this->getParameter('RetryTime'));
    }

    /**
     * Sets seconds between retries, Don't hammer an unavailable phone.
     * Default is 300 (5 min).
     *
     * @param integer $value Value to set.
     *
     * @return void
     */
    public function setRetryTime($value)
    {
        $this->setParameter('RetryTime', intval($value));
    }

    /**
     * Returns account code to use for this call.
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->getParameter('Account');
    }

    /**
     * Sets account code to use for this call.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setAccount($value)
    {
        $this->setParameter('Account', $value);
    }

    /**
     * Returns context to use for this call when answered.
     *
     * @return string
     */
    public function getContext()
    {
        return $this->getParameter('Context');
    }

    /**
     * Sets context to use for this call when answered.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setContext($value)
    {
        $this->setParameter('Context', $value);
    }

    /**
     * Returns priority to use for this call when answered.
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->getParameter('Priority');
    }

    /**
     * Sets priority to use for this call when answered.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setPriority($value)
    {
        $this->setParameter('Priority', $value);
    }

    /**
     * Returns extension to use for this call when answered.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->getParameter('Extension');
    }

    /**
     * Sets extension to use for this call when answered.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setExtension($value)
    {
        $this->setParameter('Extension', $value);
    }

    /**
     * Returns Asterisk Application to run (use instead of specifiying context,
     * extension and priority)
     *
     * @return string
     */
    public function getApplication()
    {
        return $this->getParameter('Application');
    }

    /**
     * Sets Asterisk Application to run (use instead of specifiying context,
     * extension and priority)
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setApplication($value)
    {
        $this->setParameter('Application', $value);
    }

    /**
     * Returns the options to be passed to application.
     *
     * @return string
     */
    public function getApplicationData()
    {
        $value = $this->getParameter('Data');
        if ($value !== false) {
            return explode(',', $value);
        }
        return false;
    }

    /**
     * Sets the options to be passed to application.
     *
     * @param array $value Options to set. No keys, just plain values.
     *
     * @return void
     */
    public function setApplicationData(array $options = array())
    {
        $this->setParameter('Data', implode(',', $options));
    }

    /**
     * If the file's modification time is in the future, the call file will not
     * be deleted
     *
     * @return boolean
     */
    public function getAlwaysDelete()
    {
        return $this->getParameter('AlwaysDelete') === 'Yes';
    }

    /**
     * If the file's modification time is in the future, the call file will not
     * be deleted
     *
     * @param boolean $value Value to set.
     *
     * @return void
     */
    public function setAlwaysDelete($value)
    {
        $this->setParameter('AlwaysDelete', $value ? 'Yes' : 'No');
    }

    /**
     * Sets if should move to subdir "outgoing_done" with "Status: value",
     * where value can be Completed, Expired or Failed.
     *
     * @return boolean
     */
    public function getArchive()
    {
        return $this->getParameter('Archive') === 'Yes';
    }

    /**
     * Sets if should move to subdir "outgoing_done" with "Status: value",
     * where value can be Completed, Expired or Failed.
     *
     * @param boolean $value Value to set.
     *
     * @return void
     */
    public function setArchive($value)
    {
        $this->setParameter('Archive', $value ? 'Yes' : 'No');
    }

    /**
     * Returns the text describing this call file, ready to be spooled.
     *
     * @return string
     */
    public function serialize()
    {
        $text = array();
        foreach ($this->parameters as $k => $v) {
            $text[] = $k . ': ' . $v;
        }
        foreach ($this->variables as $k => $v) {
            $text[] = 'Set: ' . $k . '=' . $v;
        }
        return implode("\n", $text);
    }

    /**
     * Deconstructs a call file from the given text.
     *
     * @param string $text A call file (intended to be pre-loaded, with
     * file_get_contents() or similar).
     *
     * @return void
     */
    public function unserialize($text)
    {
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            $data = explode(':', $line);
            if (count($data) < 2) {
                continue;
            }
            $key = trim($data[0]);
            if (isset($data[1]) && (strlen($data[1]) > 0)) {
                $value = trim($data[1]);
            } else {
                $value = '?';
            }
            if (strcasecmp($key, 'set') === 0) {
                $data = explode('=', $value);
                $key = trim($data[0]);
                if (isset($data[1]) && (strlen($data[1]) > 0)) {
                    $value = trim($data[1]);
                } else {
                    $value = '?';
                }
                $this->setVariable($key, $value);
            } else {
                $this->setParameter($key, $value);
            }
        }
    }

    /**
     * Constructor.
     *
     * @param PAGI\DialDescriptor\DialDescriptor dial descriptor
     *
     * @return void
     */
    public function __construct(DialDescriptor $dialDescriptor)
    {
        $this->parameters = array();
        $this->variables = array();

        $this->setParameter(
            'Channel',
            $dialDescriptor->getChannelDescriptor()
        );
    }
}
