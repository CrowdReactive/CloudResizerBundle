<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 17:09
 */

namespace CrowdReactive\CloudResizerBundle\Tests\Services;


use CrowdReactive\CloudResizerBundle\Services\CloudResizer;

class CloudResizerTest extends \PHPUnit_Framework_TestCase {

    public function testBuild() {
//        $provider = $this->getMock('\CrowdReactive\CloudResizerBundle\CloudResizer\Provider\CloudImage', null, array('token'));
//
//        $filter = $this->getMock('\CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface');
//        $filter->expects($this->once())->method('setParameters')->withAnyParameters()->willReturn(null);
//        $filter->expects($this->once())->method('getParameters')->with()->willReturn(array());
//        $filter->expects($this->once())->method('getProvider')->with()->willReturn($provider);
//
//        $key = 'filterKey';
//        $provider->expects($this->once())->method('getFilterName')->with($filter)->willReturn($key);
//
//        $service = new CloudResizer();
//        $service->setFilter($key, $filter);
//
//        $service->build('url', $key, array());
    }
} 