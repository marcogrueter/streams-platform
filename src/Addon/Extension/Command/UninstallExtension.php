<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasUninstalled;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use App\Console\Kernel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;

/**
 * Class UninstallExtension
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class UninstallExtension implements SelfHandling
{

    /**
     * The extension to uninstall.
     *
     * @var Extension
     */
    protected $extension;

    /**
     * Create a new UninstallExtension instance.
     *
     * @param Extension $extension
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }

    /**
     * Handle the command.
     *
     * @param Kernel     $console
     * @param Dispatcher $events
     * @return bool
     */
    public function handle(Kernel $console, Dispatcher $events)
    {
        $options = [
            '--addon' => $this->extension->getNamespace()
        ];

        $console->call('migrate:reset', $options);
        $console->call('streams:cleanup');

        $events->fire(new ExtensionWasUninstalled($this->extension));

        return true;
    }
}
