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
 * This is an interface so we can decorate it later.
 */
interface ResultInterface
{
    /**
     * Returns original line.
     *
     * @return string
     */
    public function getOriginalLine();

    /**
     * Returns the integer value of the code returned by agi.
     *
     * @return integer
     */
    public function getCode();

    /**
     * Returns result (result=xxx) from the result.
     *
     * @return integer
     */
    public function getResult();

    /**
     * Compares result to a given value.
     *
     * @param string $value Value to match against.
     *
     * @return Boolean
     */
    public function isResult($value);

    /**
     * Returns true if this command returned any data.
     *
     * @return Boolean
     */
    public function hasData();

    /**
     * Returns data, if any. False if none.
     *
     * @return string
     */
    public function getData();
}
