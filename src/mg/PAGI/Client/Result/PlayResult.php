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
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://www.noneyet.ar/
 */
namespace PAGI\Client\Result;

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
 * @license    http://www.noneyet.ar/ Apache License 2.0
 * @link       http://www.noneyet.ar/
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