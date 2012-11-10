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
 * This class parses and encapsulates the result from an agi command. You must
 * instantiate it with the result line as came from asterisk.
 */
class Result implements ResultInterface
{
    /**
     * Result code (3 digits).
     *
     * @var integer
     */
    private $code;

    /**
     * Result string (if any), from result=xxxxx string.
     *
     * @var string
     */
    private $result;

    /**
     * Result data (if any).
     *
     * @var string
     */
    private $data;

    /**
     * AGI result line (i.e: xxx result=zzzzzz [yyyyyy])
     *
     * @var string
     */
    private $line;

    /**
     * Constructor. Will parse the data that came from agi.
     *
     * @param string $line Result literal as came from agi.
     */
    public function __construct($line)
    {
        $this->line = $line;
        $this->result = false;
        $this->data = false;

        $response = explode(' ', $line);
        $this->code = $response[0];

        $this->result = explode('=', $response[1]);
        if (isset($this->result[1])) {
            $this->result = $this->result[1];
        }

        if (isset($response[2])) {
            unset($response[0]);
            unset($response[1]);
            $this->data = implode(' ', $response);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalLine()
    {
        return $this->line;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function isResult($value)
    {
        return $this->result == $value;
    }

    /**
     * {@inheritdoc}
     */
    public function hasData()
    {
        return $this->data !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Standard.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('[ Result for |%s| code: |%d| result: |%d| data: |%s| ]',
            $this->getOriginalLine(),
            $this->getCode(),
            $this->getResult(),
            $this->getData()
        );
    }
}
