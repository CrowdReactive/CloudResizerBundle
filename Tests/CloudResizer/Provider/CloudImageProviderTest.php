<?php

namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\CloudImageProvider;

class CloudImageProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var CloudImageProvider */
    protected $provider;

    public function setUp()
    {
        $this->provider = new CloudImageProvider('123abc');
    }


    public function testToken()
    {
        $this->assertEquals('123abc', $this->provider->getToken());
    }
}