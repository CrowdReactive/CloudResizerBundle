<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 19:29
 */

namespace CrowdReactive\CloudResizerBundle\Tests\DependencyInjection;


use CrowdReactive\CloudResizerBundle\DependencyInjection\CrowdReactiveCloudResizerExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

class CrowdReactiveCloudResizerExtensionTest extends \PHPUnit_Framework_TestCase {

    /** @var CrowdReactiveCloudResizerExtension */
    private $extension;

    /** @var ContainerBuilder */
    private $container;

    public function setUp() {
        parent::setUp();

        $this->extension = new CrowdReactiveCloudResizerExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    public function loadConfiguration(ContainerBuilder $container) {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../../Resources/config'));
        $loader->load('config.yml');
    }

    public function testGetConfigWithDefaultValues() {
        $this->loadConfiguration($this->container);
        $this->container->compile();
    }
} 