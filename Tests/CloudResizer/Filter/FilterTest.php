<?php

namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer\Filter;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\Filter;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    public function testNoNoticeWhenParameterDoesNotExist()
    {
        $provider = $this->getMock('CrowdReactive\CloudResizerBundle\CloudResizer\Provider\Provider');
        $filter = new Filter($provider);

        $this->assertFalse($filter->hasParameter('unknown'));
        $filter->getParameter('unknown');
    }
}
