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
 * A result decorator.
 */
abstract class ResultDecorator implements ResultInterface
{
    /**
     * Our decorated result.
     *
     * @var ResultInterface
     */
    private $result;

    /**
     * Constructor.
     *
     * @param ResultInterface $result Result to decorate
     */
    public function __construct(ResultInterface $result)
    {
        $this->result = $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalLine()
    {
        return $this->result->getOriginalLine();
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->result->getCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->result->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function isResult($value)
    {
        return $this->result->isResult($value);
    }

    /**
     * {@inheritdoc}
     */
    public function hasData()
    {
        return $this->result->hasData();
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->result->getData();
    }

    /**
     * Standard procedure.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->result->__toString();
    }
}
