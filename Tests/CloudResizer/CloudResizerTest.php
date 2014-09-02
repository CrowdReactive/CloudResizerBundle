<?php

namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;
use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;
use CrowdReactive\CloudResizerBundle\CloudResizer\CloudResizer;

class CloudResizerTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        // Stub data
        $url = 'https://www.google.co.uk/images/srpr/logo11w.png';
        $filterName = 'logo_small';

        $provider = $this->getMockProvider();
        $filter = $this->getMockFilter();

        $filter->expects($this->once())->method('getProvider')->willReturn($provider);
        $provider->expects($this->once())->method('build')->with($filter, $url)->willReturn('//example.com/'.$url);

        $service = new CloudResizer();
        $service->setFilter($filterName, $filter);
        $this->assertEquals('//example.com/'.$url, $service->build($url, $filterName));
    }

    public function testFilterSetter()
    {
        $service = new CloudResizer();
        $filter = $this->getMockFilter();

        $service->setFilter('thumbnail', $filter);
        $this->assertSame($filter, $service->getFilter('thumbnail'));
    }

    /**
     * @return FilterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockFilter()
    {
        return $this->getMock('CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface');
    }

    /**
     * @return ProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockProvider()
    {
        return $this->getMock('CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface');
    }
}
