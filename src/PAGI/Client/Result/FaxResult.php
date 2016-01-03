<?php
/**
 * This decorated result adds the functionality to check for a fax result.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Result
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
namespace PAGI\Client\Result;

use PAGI\Exception\ChannelDownException;

/**
 * This decorated result adds the functionality to check for a fax result.
 *
 * PHP Version 5
 *
 * @category   Pagi
 * @package    Client
 * @subpackage Result
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link       http://marcelog.github.com/PAGI/
 */
class FaxResult extends ExecResult
{
    /**
     * Local station ID.
     * @var string
     */
    private $_localId;

    /**
     * Local header.
     * @var string
     */
    private $_localHeader;

    /**
     * Remote station ID.
     * @var string
     */
    private $_remoteId;

    /**
     * True if successfull.
     * @var boolean
     */
    private $_result;

    /**
     * Error detail (if $_result === false)
     * @var string
     */
    private $_error;

    /**
     * Bitrate for the operation.
     * @var integer
     */
    private $_bitrate;

    /**
     * Total pages for the operation.
     * @var integer
     */
    private $_pages;

    /**
     * Resolution for the operation.
     * @var string
     */
    private $_resolution;

    /**
     * Returns local station id.
     *
     * @return string
     */
    public function getLocalStationId()
    {
        return $this->_localId;
    }

    /**
     * Sets local station id.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setLocalStationId($value)
    {
        $this->_localId = $value;
    }

    /**
     * Returns local header.
     *
     * @return string
     */
    public function getLocalHeaderInfo()
    {
        return $this->_localHeader;
    }

    /**
     * Sets local header.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setLocalHeaderInfo($value)
    {
        $this->_localHeader = $value;
    }

    /**
     * True if the operation was successfull.
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->_result;
    }

    /**
     * Sets operation result (if failed).
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setResult($value)
    {
        $this->_result = $value;
    }

    /**
     * Returns error description (if failed).
     *
     * @return string
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * Sets error detail.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setError($value)
    {
        $this->_error = $value;
    }

    /**
     * Returns remote station id.
     *
     * @return string
     */
    public function getRemoteStationId()
    {
        return $this->_remoteId;
    }

    /**
     * Sets remote station id.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setRemoteStationId($value)
    {
        $this->_remoteId = $value;
    }

    /**
     * Returns number of pages.
     *
	 * @return integer
     */
    public function getPages()
    {
        return $this->_pages;
    }

    /**
     * Sets number of pages.
     *
     * @param integer $value Value to set.
     *
     * @return void
     */
    public function setPages($value)
    {
        $this->_pages = $value;
    }

    /**
     * Returns bitrate.
     *
	 * @return integer
     */
    public function getBitrate()
    {
        return $this->_bitrate;
    }

    /**
     * Sets bitrate.
     *
     * @param integer $value Value to set.
     *
     * @return void
     */
    public function setBitrate($value)
    {
        $this->_bitrate = $value;
    }

    /**
     * Returns resolution for the operation.
     *
     * @return string
     */
    public function getResolution()
    {
        return $this->_resolution;
    }

    /**
     * Sets resolution.
     *
     * @param string $value Value to set.
     *
     * @return void
     */
    public function setResolution($value)
    {
        $this->_resolution = $value;
    }

    /**
     * (non-PHPdoc)
     * @see PAGI\Client\Result.ResultDecorator::__toString()
     */
    public function __toString()
    {
        return
            '[ FaxResult: '
            . ' Resolution: ' . $this->getResolution()
            . ' Bitrate: ' . intval($this->getBitrate())
            . ' Pages: ' . intval($this->getPages())
            . ' LocalId: ' . $this->getLocalStationId()
            . ' LocalHeader: ' . $this->getLocalHeaderInfo()
            . ' RemoteId: ' . $this->getRemoteStationId()
            . ' Error: ' . $this->getError()
            . ' Result: ' . ($this->isSuccess() ? 'Success': 'Failed')
            . ']'
        ;
    }
    /**
     * Constructor.
     *
     * @param IResult $result Result to decorate.
     *
     * @return void
     */
    public function __construct(IResult $result)
    {
        parent::__construct($result);
        $this->_resolution = false;
        $this->_bitrate = false;
        $this->_pages = false;
        $this->_localId = false;
        $this->_remoteId = false;
        $this->_localHeader = false;
        $this->_result = false;
        $this->_error = false;
    }
}