<?php

namespace CrowdReactive\CloudResizerBundle\DependencyInjection;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;
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

        foreach ($config['filters'] as $key => $info) {
            /** @todo Lazy load */
            if (!class_exists($info['type']) || !is_subclass_of($info['type'], 'CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface')) {
                throw new \Exception('Filter must implement FilterInterface');
            }

            /** @var FilterInterface $filter */
            $filter = new $info['type'];
            $filter->setParameters($info['parameters']);

            if ($info['provider'][0] == '@')
                $info['provider'] = substr($info['provider'], 1);
            /** @var ProviderInterface $provider */
            $provider = $container->get($info['provider']);
            $filter->setProvider($provider);

            $cloudResizer->setFilter($key, $filter);
        }
    }

    public function getAlias() {
        return 'crowdreactive_cloudresizer';
    }
}
