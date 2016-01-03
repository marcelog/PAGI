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
    private $localId;

    /**
     * Local header.
     * @var string
     */
    private $localHeader;

    /**
     * Remote station ID.
     * @var string
     */
    private $remoteId;

    /**
     * True if successfull.
     * @var boolean
     */
    private $result;

    /**
     * Error detail (if $result === false)
     * @var string
     */
    private $error;

    /**
     * Bitrate for the operation.
     * @var integer
     */
    private $bitrate;

    /**
     * Total pages for the operation.
     * @var integer
     */
    private $pages;

    /**
     * Resolution for the operation.
     * @var string
     */
    private $resolution;

    /**
     * Returns local station id.
     *
     * @return string
     */
    public function getLocalStationId()
    {
        return $this->localId;
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
        $this->localId = $value;
    }

    /**
     * Returns local header.
     *
     * @return string
     */
    public function getLocalHeaderInfo()
    {
        return $this->localHeader;
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
        $this->localHeader = $value;
    }

    /**
     * True if the operation was successfull.
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->result;
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
        $this->result = $value;
    }

    /**
     * Returns error description (if failed).
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
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
        $this->error = $value;
    }

    /**
     * Returns remote station id.
     *
     * @return string
     */
    public function getRemoteStationId()
    {
        return $this->remoteId;
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
        $this->remoteId = $value;
    }

    /**
     * Returns number of pages.
     *
     * @return integer
     */
    public function getPages()
    {
        return $this->pages;
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
        $this->pages = $value;
    }

    /**
     * Returns bitrate.
     *
     * @return integer
     */
    public function getBitrate()
    {
        return $this->bitrate;
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
        $this->bitrate = $value;
    }

    /**
     * Returns resolution for the operation.
     *
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
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
        $this->resolution = $value;
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
        $this->resolution = false;
        $this->bitrate = false;
        $this->pages = false;
        $this->localId = false;
        $this->remoteId = false;
        $this->localHeader = false;
        $this->result = false;
        $this->error = false;
    }
}
