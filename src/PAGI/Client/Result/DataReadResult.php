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
 * This decorated result adds the functionality to check for user input (more
 * than one digit).
 */
class DataReadResult extends DigitReadResult
{
    /**
     * Constructor.
     *
     * @param ResultInterface $result Result to decorate
     */
    public function __construct(ResultInterface $result)
    {
        parent::__construct($result);

        // reset timeout flag. This is because wait-for-digit returns 0 on timeout
        // and the result is the ascii char of the digit read, while other read
        // functions return the digits and (timeout) on data to signal a timeout.
        $this->timeout = false;
        $this->digits = $result->getResult();

        if ($result->hasData()) {
            $this->timeout = (strpos($result->getData(), '(timeout)') !== false);
        }
    }
}
