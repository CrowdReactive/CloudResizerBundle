<?php

namespace CrowdReactive\CloudResizerBundle\Tests\Services;

use CrowdReactive\CloudResizerBundle\Services\CloudResizer;

class CloudResizerTest extends \PHPUnit_Framework_TestCase {

    public function testBuild() {
        // Stub data
        $url = 'https://www.google.co.uk/images/srpr/logo11w.png';
        $filterName = 'logo_small';
        $parameters = ['height' => 50];

        // Mocked provider
        $provider = $this->getMockBuilder('CrowdReactive\CloudResizerBundle\CloudResizer\Provider\CloudImage')
            ->disableOriginalConstructor()
            ->getMock();
        $provider->expects($this->once())->method('build')->with($parameters, $url)->willReturn('//token.cloudimage.io/s/height/50/' . $url);

        // Mocked filter
        $filter = $this->getMockBuilder('CrowdReactive\CloudResizerBundle\CloudResizer\Filter')
            ->disableOriginalConstructor()
            ->getMock();
        $filter->expects($this->atLeastOnce())->method('getParameters')->with()->willReturn($parameters);
        $filter->expects($this->once())->method('getProvider')->with()->willReturn($provider);

        $service = new CloudResizer();
        $service->setFilter($filterName, $filter);
        $this->assertEquals('//token.cloudimage.io/s/height/50/' . $url, $service->build($url, $filterName));
    }
} 