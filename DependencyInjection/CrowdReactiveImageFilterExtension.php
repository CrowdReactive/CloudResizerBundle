<?php

namespace CrowdReactive\ImageFilterBundle\DependencyInjection;

use CrowdReactive\ImageFilterBundle\ImageFilter\Filter\FilterInterface;
use CrowdReactive\ImageFilterBundle\ImageFilter\Provider\ProviderInterface;
use CrowdReactive\ImageFilterBundle\Services\ImageFilter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class CrowdReactiveImageFilterExtension extends Extension
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

        /** @var ImageFilter $imageFilter */
        $imageFilter = $container->get('crowdreactive_image_filter.service');

        foreach ($config['filters'] as $info) {
            /** @todo Lazy load */
            if (!class_exists($info['type']) || !is_subclass_of($info['type'], 'CrowdReactive\ImageFilterBundle\ImageFilter\Filter\FilterInterface')) {
                throw new \Exception('Filter must implement FilterInterface');
            }

            /** @var FilterInterface $filter */
            $filter = new $info['type'];
            $filter->setParameters($info['parameters']);

            /** @var ProviderInterface $provider */
            $provider = $container->get($info['provider']);
            $filter->setProvider($provider);

            $imageFilter->setFilter($info['name'], $filter);
        }
    }
}
