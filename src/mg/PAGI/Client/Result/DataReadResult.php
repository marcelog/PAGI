<?php
/**
 * This decorated result adds the functionality to check for user input (more
 * than one digit).
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
 * This decorated result adds the functionality to check for user input (more
 * than one digit).
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
class DataReadResult extends DigitReadResult
{

    /**
     * Constructor.
     *
     * @param IResult $result Result to decorate.
     */
    public function __construct(IResult $result)
    {
        parent::__construct($result);
        // Reset timeout flag. This is because wait-for-digit returns 0 on timeout
        // and the result is the ascii char of the digit read, while other read
        // functions return the digits and (timeout) on data to signal a timeout.
        $this->_timeout = false;
        $this->_digits = $result->getResult();
        if ($result->hasData()) {
            $this->_timeout = (strpos($result->getData(), '(timeout)') !== false);
        }
    }
}