<?php

namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ImgixProvider;

class ImgixProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var ImgixProvider */
    protected $provider;

    public function setUp()
    {
        $this->provider = new ImgixProvider('example', '123abc');
    }

    public function testDefaultFilter()
    {
        $this->assertInstanceOf('CrowdReactive\CloudResizerBundle\CloudResizer\Filter\ImgixFilter', $this->provider->getFilterInstance());
    }

    public function testSubdomain()
    {
        $this->assertEquals('example', $this->provider->getSubdomain());
    }

    public function testToken()
    {
        $this->assertEquals('123abc', $this->provider->getToken());
    }
}
