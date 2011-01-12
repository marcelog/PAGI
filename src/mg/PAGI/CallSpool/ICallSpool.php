<?php
/**
 * An interface to access asterisk call spool.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  CallSpool
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */
namespace PAGI\CallSpool;

/**
 * An interface to access asterisk call spool.
 *
 * PHP Version 5
 *
 * @category Pagi
 * @package  CallSpool
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @link     http://www.noneyet.ar/
 */
interface ICallSpool
{
    /**
     * Spools the given call.
     *
     * @param CallFile $call     Call to spool.
     * @param integer  $schedule Optional unix timestamp to schedule the call.
     *
     * @return void
     */
    public function spool(CallFile $call, $schedule = false);
}