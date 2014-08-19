<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 16:40
 */

namespace CrowdReactive\ImageFilterBundle\Tests\Twig;

use CrowdReactive\ImageFilterBundle\Twig\FilterExtension;

class FilterExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testFilter() {
        $service = $this->getMock('\CrowdReactive\ImageFilterBundle\Services\ImageFilter');
        $service->expects($this->once())->method('build')->with('url', 'logo')->willReturn('url');

        $extension = new FilterExtension($service);

        $this->assertCount(1, $extension->getFilters());
        $this->assertEquals('url', $extension->imageFilter('url', 'logo'));
    }
} 