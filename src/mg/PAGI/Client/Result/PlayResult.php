<?php
/**
 * This class decorates a read result with a play operation like stream file,
 * say digits, etc.
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

use PAGI\Exception\SoundFileException;

/**
 * This class decorates a read result with a play operation like stream file,
 * say digits, etc.
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
class PlayResult extends ReadResultDecorator
{
    /**
     * Constructor.
     *
     * @param IReadResult $result Result to decorate.
     */
    public function __construct(IReadResult $result)
    {
        parent::__construct($result);
        if ($result->hasData()) {
            // check offset
            $data = explode('=', $result->getData());
            if (isset($data[1])) {
                if ($data[1] == 0) {
                    throw new SoundFileException('Invalid format?');
                }
            }
        }
    }
}
