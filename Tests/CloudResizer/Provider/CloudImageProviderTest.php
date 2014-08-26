<?php

namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\CloudImage;

class CloudImageProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var CloudImage */
    protected $provider;

    public function setUp()
    {
        $this->provider = new CloudImage('123abc');
    }

    public function testToken()
    {
        $this->assertEquals('123abc', $this->provider->getToken());
    }

    public function testBuild()
    {
        $url = $this->provider->build(['height' => 200], 'http://google.com/logo.png');
        $this->assertEquals('//123abc.cloudimage.io/s/height/200/http://google.com/logo.png', $url);
    }
}