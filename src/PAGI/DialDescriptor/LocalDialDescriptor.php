<?php

namespace PAGI\DialDescriptor;

/**
 * SIP Dial Descriptor class.
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Thomas Stähle <staelche@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
class LocalDialDescriptor extends DialDescriptor
{
    const TECHNOLOGY = 'LOCAL';

    /**
     * (non-PHPdoc)
     * @see DialDescriptor::getTechnology()
     */
    public function getTechnology()
    {
        return self::TECHNOLOGY;
    }

    /**
     * (non-PHPdoc)
     * @see DialDescriptor::getChannelDescriptor()
     */
    public function getChannelDescriptor()
    {
        return self::TECHNOLOGY .'/' .$this->target;
    }

    /**
     * constructor.
     *
     * @param string $context The asterisk context
     * @param string $extension The asterisk extension
     */
    public function __construct($context, $extension)
    {
        $this->target = $extension . '@' . $context;
    }
}
