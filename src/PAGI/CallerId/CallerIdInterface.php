<?php

/*
 * This file is part of the PAGI package.
 *
 * (c) Marcelo Gornstein <marcelog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PAGI\CallerId;

/**
 * AGI Caller id facade.
 */
interface CallerIdInterface
{
    /**
     * Sets caller id ani. CALLERID(ani).
     *
     * @param string $value ANI
     */
    public function setANI($value);

    /**
     * Returns caller id ani. CALLERID(ani)
     *
     * @return string
     */
    public function getANI();

    /**
     * Sets caller id dnid. CALLERID(dnid)
     *
     * @param string $value DNID
     */
    public function setDNID($value);

    /**
     * Returns caller id dnid. CALLERID(dnid)
     *
     * @return string
     */
    public function getDNID();

    /**
     * Sets caller id rdnis. CALLERID(rdnis)
     *
     * @param string $value RDNIS
     */
    public function setRDNIS($value);

    /**
     * Returns caller id rdnis. CALLERID(rdnis)
     *
     * @return string
     */
    public function getRDNIS();

    /**
     * Sets caller id name. CALLERID(name)
     *
     * @param string $value Name
     */
    public function setName($value);

    /**
     * Returns caller id name. CALLERID(name)
     *
     * @return string
     */
    public function getName();

    /**
     * Returns caller id number. CALLERID(num)
     *
     * @return string
     */
    public function getNumber();

    /**
     * Sets caller id number. CALLERID(num)
     *
     * @param string $value Number
     */
    public function setNumber($value);

    /**
     * Changes the caller id presentation mode.
     *
     * @param string $presentationMode Can be one of:
     *
     * allowed_not_screened  - Presentation Allowed, Not Screened
     * allowed_passed_screen - Presentation Allowed, Passed Screen
     * allowed_failed_screen - Presentation Allowed, Failed Screen
     * allowed               - Presentation Allowed, Network Number
     * prohib_not_screened   - Presentation Prohibited, Not Screened
     * prohib_passed_screen  - Presentation Prohibited, Passed Screen
     * prohib_failed_screen  - Presentation Prohibited, Failed Screen
     * prohib                - Presentation Prohibited, Network Number
     * unavailable           - Number Unavailable
     */
    public function setCallerPres($presentationMode);
}
