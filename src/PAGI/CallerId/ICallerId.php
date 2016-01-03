<?php
/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Callerid
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/PAGI/
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
namespace PAGI\CallerId;

use PAGI\Client\IClient;

/**
 * AGI Caller id facade.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  Callerid
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/PAGI/ Apache License 2.0
 * @link     http://marcelog.github.com/PAGI/
 */
interface ICallerId
{
    /**
     * Sets caller id ani. CALLERID(ani).
     *
     * @param string $value ANI.
     *
     * @return void
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
     * @param string $value DNID.
     *
     * @return void
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
     * @param string $value RDNIS.
     *
     * @return void
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
     * @param string $value Name.
     *
     * @return void
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
     * @param string $value Number.
     *
     * @return void
     */
    public function setNumber($value);

    /**
     * Changes the caller id presentation mode.
     *
     * @param string $presentationMode Can be one of:
     * allowed_not_screened - Presentation Allowed, Not Screened.
     * allowed_passed_screen - Presentation Allowed, Passed Screen.
     * allowed_failed_screen - Presentation Allowed, Failed Screen.
     * allowed - Presentation Allowed, Network Number.
     * prohib_not_screened - Presentation Prohibited, Not Screened.
     * prohib_passed_screen - Presentation Prohibited, Passed Screen.
     * prohib_failed_screen - Presentation Prohibited, Failed Screen.
     * prohib - Presentation Prohibited, Network Number.
     * unavailable - Number Unavailable.
     *
     * @return void
     */
    public function setCallerPres($presentationMode);
}