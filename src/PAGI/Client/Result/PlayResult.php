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

use PAGI\Exception\SoundFileException;

/**
 * This class decorates a read result with a play operation like stream file,
 * say digits, etc.
 */
class PlayResult extends ReadResultDecorator
{
    /**
     * Constructor.
     *
     * @param ReadResultInterface $result Result to decorate
     */
    public function __construct(ReadResultInterface $result)
    {
        parent::__construct($result);

        if ($result->hasData()) {
            // check offset
            if ($result->hasData()) {
                $data = explode('=', $result->getData());

                if (isset($data[1])) {
                    if ($data[1] == 0) {
                        throw new SoundFileException('Invalid format?');
                    }
                }
            }
        }
    }
}
