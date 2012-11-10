<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\Client\Result;

/**
 * This decorated result adds the functionality to check for a fax result.\
 */
class FaxResult extends ExecResult
{
    /**
     * Local station ID.
     *
     * @var string
     */
    private $localId;

    /**
     * Local header.
     *
     * @var string
     */
    private $localHeader;

    /**
     * Remote station ID.
     *
     * @var string
     */
    private $remoteId;

    /**
     * True if successfull.
     *
     * @var Boolean
     */
    private $result;

    /**
     * Error detail (if $result === false)
     *
     * @var string
     */
    private $error;

    /**
     * Bitrate for the operation.
     *
     * @var integer
     */
    private $bitrate;

    /**
     * Total pages for the operation.
     *
     * @var integer
     */
    private $pages;

    /**
     * Resolution for the operation.
     *
     * @var string
     */
    private $resolution;

    /**
     * Constructor.
     *
     * @param ResultInterface $result Result to decorate
     */
    public function __construct(ResultInterface $result)
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
     * @param string $value Value to set
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
     * @param string $value Value to set
     */
    public function setLocalHeaderInfo($value)
    {
        $this->localHeader = $value;
    }

    /**
     * True if the operation was successfull.
     *
     * @return Boolean
     */
    public function isSuccess()
    {
        return $this->result;
    }

    /**
     * Sets operation result (if failed).
     *
     * @param string $value Value to set
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
     * @param string $value Value to set
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
     * @param string $value Value to set
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
     * @param integer $value Value to set
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
     * @param integer $value Value to set
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
     * @param string $value Value to set
     */
    public function setResolution($value)
    {
        $this->resolution = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('[ FaxResult: Resolution: %s Bitrate: %d Pages: %d LocalId: %s LocalHeader: %s RemoteId: %s Error: %s Result: %s ]',
            $this->getResolution(),
            intval($this->getBitrate()),
            intval($this->getPages()),
            $this->getLocalStationId(),
            $this->getLocalHeaderInfo(),
            $this->getRemoteStationId(),
            $this->getError(),
            ($this->isSuccess() ? 'Success': 'Failed')
        );
    }
}
