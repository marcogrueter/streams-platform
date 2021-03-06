<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Illuminate\Container\Container;

/**
 * Class AddonBinder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonBinder
{

    /**
     * The addon provider.
     *
     * @var AddonProvider
     */
    protected $provider;

    /**
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The addon integrator.
     *
     * @var AddonIntegrator
     */
    protected $integrator;

    /**
     * The addon dispatcher.
     *
     * @var AddonDispatcher
     */
    protected $dispatcher;

    /**
     * The addon configuration utility.
     *
     * @var AddonConfiguration
     */
    protected $configuration;

    /**
     * Create a new AddonBinder instance.
     *
     * @param Container          $container
     * @param AddonProvider      $provider
     * @param AddonIntegrator    $integrator
     * @param AddonDispatcher    $dispatcher
     * @param AddonConfiguration $configuration
     */
    public function __construct(
        Container $container,
        AddonProvider $provider,
        AddonIntegrator $integrator,
        AddonDispatcher $dispatcher,
        AddonConfiguration $configuration
    ) {
        $this->provider      = $provider;
        $this->container     = $container;
        $this->dispatcher    = $dispatcher;
        $this->integrator    = $integrator;
        $this->configuration = $configuration;
    }

    /**
     * Register an addon.
     *
     * @param $path
     * @param $enabled
     * @param $installed
     */
    public function register($path, array $enabled, array $installed)
    {
        $vendor = strtolower(basename(dirname($path)));
        $slug   = strtolower(substr(basename($path), 0, strpos(basename($path), '-')));
        $type   = strtolower(substr(basename($path), strpos(basename($path), '-') + 1));

        $addon = studly_case($vendor) . '\\' . studly_case($slug) . studly_case($type) . '\\' . studly_case(
                $slug
            ) . studly_case($type);

        $addon = app($addon)
            ->setPath($path)
            ->setType($type)
            ->setSlug($slug)
            ->setVendor($vendor);

        // If the addon supports states - set the state now.
        if ($addon instanceof Module || $addon instanceof Extension) {
            $addon
                ->setInstalled(in_array($addon->getNamespace(), $installed))
                ->setEnabled(in_array($addon->getNamespace(), $enabled));
        }

        $this->container->instance(get_class($addon), $addon);
        $this->container->instance($addon->getNamespace(), $addon);

        /**
         * Load addon configuration before running
         * the addon's service provider so we can
         * use configurable bindings.
         */
        $this->configuration->load($addon);

        // Continue loading things.
        $this->provider->register($addon);
        $this->integrator->register($addon);
        $this->dispatcher->addonWasRegistered($addon);
    }
}
