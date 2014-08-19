<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 19:29
 */

namespace CrowdReactive\CloudResizerBundle\Tests\DependencyInjection;


use CrowdReactive\CloudResizerBundle\DependencyInjection\CrowdReactiveCloudResizerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CrowdReactiveCloudResizerExtensionTest extends \PHPUnit_Framework_TestCase {

    private $extension;

    private $root;

    public function setUp()
    {
        parent::setUp();

        $this->extension = $this->getExtension();
        $this->root      = "my_bundle";
    }

    public function testGetConfigWithDefaultValues()
    {
        $this->extension->load(array(), $container = $this->getContainer());
    }

    public function testGetConfigWithOverrideValues()
    {
        $config = array();

        $this->extension->load(array($config), $container = $this->getContainer());
    }

    protected function getExtension()
    {
        return new CrowdReactiveCloudResizerExtension();
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
} 