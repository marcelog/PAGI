<?php
/**
 * SIP Dial Descriptor class.
 *
 * PHP Version 5.3
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\DialDescriptor;

/**
 * SIP Dial Descriptor class.
 *
 * @category PAGI
 * @package  DialDescriptor
 * @author   Agustín Gutiérrez <agu.gutierrez@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
**/
class SIPDialDescriptor extends DialDescriptor
{
    const TECHNOLOGY = 'SIP';

    /**
     * SIP provider.
     *
     * @var string
     */
    protected $provider = null;

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
        $descriptor = self::TECHNOLOGY .'/' .$this->target;

        if (null !== $this->provider) {
            $descriptor .= '@' .$this->provider;
        }

        return $descriptor;
    }

    /**
     * Class constructor.
     *
     * @param string $target dial target
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * Set SIP provider.
     *
     * @param string $provider SIP provider
     * 
     * @return void
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

}
