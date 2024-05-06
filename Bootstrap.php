<?php declare(strict_types=1);
/**
 * @package Plugin\plugin_test
 * @author Dennis Heinrich
 */

namespace Plugin\plugin_test;

use JTL\Events\Dispatcher;
use JTL\Plugin\Bootstrapper;

/**
 * Class Bootstrap
 * @package Plugin\plugin_test
 */
class Bootstrap extends Bootstrapper
{
    /**
     * Executed on each plugin call (e.g. on each page visit)
     * @param Dispatcher $dispatcher
     * @return void
     */
    public function boot(Dispatcher $dispatcher): void
    {
        parent::boot($dispatcher);
    }
}
