<?php

namespace CrowdReactive\CloudResizerBundle\DependencyInjection;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;
use CrowdReactive\CloudResizerBundle\Services\CloudResizer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class CrowdReactiveCloudResizerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        /**
         * Load filters from configuration and add to the service
         */

        /** @var CloudResizer $cloudResizer */
        $cloudResizer = $container->get('crowdreactive_cloudresizer.service');

        foreach ($config['filters'] as $name => $info) {
            /** @var ProviderInterface $provider */
            $provider = $container->get($info['provider']);

            $filter = $provider->getFilterInstance();
            $filter->setParameters($info['parameters']);

            $cloudResizer->setFilter($name, $filter);
        }
    }

    public function getAlias() {
        return 'crowdreactive_cloudresizer';
    }
}
