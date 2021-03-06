<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled;

/**
 * Class ModuleInstalledListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Listener
 */
class MarkModuleInstalled
{

    /**
     * The module repository.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface
     */
    protected $modules;

    /**
     * Create a new ModuleInstalledListener instance.
     *
     * @param ModuleRepositoryInterface $modules
     */
    public function __construct(ModuleRepositoryInterface $modules)
    {
        $this->modules = $modules;
    }

    /**
     * When a module is physically installed we need
     * to update it's database record as installed too.
     *
     * @param ModuleWasInstalled $event
     */
    public function handle(ModuleWasInstalled $event)
    {
        $this->modules->install($event->getModule());
    }
}
