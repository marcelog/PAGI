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
 * Interface for a read result, so it can be decorated later.
 */
interface ReadResultInterface extends ResultInterface
{
    /**
     * True if the operation completed and no input was received from the user.
     *
     * @return Boolean
     */
    public function isTimeout();

    /**
     * Returns digits read. False if none.
     *
     * @return string
     */
    public function getDigits();
    /**
     * Returns the number of digits read.
     *
     * @return integer
     */
    public function getDigitsCount();
}
