<?php

namespace CrowdReactive\CloudResizerBundle\Tests\DependencyInjection;

use CrowdReactive\CloudResizerBundle\CloudResizer\CloudResizer;
use CrowdReactive\CloudResizerBundle\DependencyInjection\CrowdReactiveCloudResizerExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\ResolveDefinitionTemplatesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dump\Container;
use Symfony\Component\DependencyInjection\Loader;

class CrowdReactiveCloudResizerExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var CrowdReactiveCloudResizerExtension */
    private $extension;

    /** @var ContainerBuilder */
    private $container;

    public function setUp()
    {
        $this->extension = new CrowdReactiveCloudResizerExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    private function compileContainer($file)
    {
        $container = new ContainerBuilder();
        $extension = new CrowdReactiveCloudResizerExtension();

        $container->registerExtension($extension);

        // Load from Tests/Resources/config
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/Fixtures/config'));
        $loader->load($file);

        $container->compile();

        return $container;
    }

    public function testParameters()
    {
        $container = new ContainerBuilder();
        $extension = new CrowdReactiveCloudResizerExtension();

        $extension->load([], $container);

        $this->assertTrue($container->hasParameter('crowd_reactive_cloud_resizer.service.class'));
        $this->assertTrue($container->hasParameter('crowd_reactive_cloud_resizer.twig_extension.class'));
        $this->assertTrue($container->hasParameter('crowd_reactive_cloud_resizer.provider.cloudimage.class'));
    }

    public function testInitialServices()
    {
        $container = new ContainerBuilder();
        $extension = new CrowdReactiveCloudResizerExtension();

        $extension->load([], $container);

        $this->assertInstanceOf('CrowdReactive\CloudResizerBundle\CloudResizer\CloudResizer', $container->get('crowd_reactive_cloud_resizer.service'));
        $this->assertInstanceOf('CrowdReactive\CloudResizerBundle\Twig\CloudResizerExtension', $container->get('crowd_reactive_cloud_resizer.twig_extension'));
    }

    public function testBasicConfiguration()
    {
        $container = $this->compileContainer('basic.yml');

        // Test CloudImage provider is defined as a service
        $this->assertTrue($container->hasDefinition('crowd_reactive_cloud_resizer.provider.my_cloudimage'));
        $this->assertInstanceOf('CrowdReactive\CloudResizerBundle\CloudResizer\Provider\CloudImageProvider', $container->get('crowd_reactive_cloud_resizer.provider.my_cloudimage'));
        $this->assertEquals('abc123', $container->get('crowd_reactive_cloud_resizer.provider.my_cloudimage')->getToken());

        // Test filter exists
        /** @var CloudResizer $service */
        $service = $container->get('crowd_reactive_cloud_resizer.service');
        $this->assertInstanceOf('CrowdReactive\CloudResizerBundle\CloudResizer\Filter\CloudImageFilter', $service->getFilter('background_thumb'));
    }

    public function testGetConfigWithDefaultValues()
    {
        $this->loadConfiguration($this->container);
        $this->container->compile();
    }
}
