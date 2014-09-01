<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 16:40
 */

namespace CrowdReactive\CloudResizerBundle\Tests\Twig;

use CrowdReactive\CloudResizerBundle\Twig\CloudResizerExtension;

class CloudResizerExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $service = $this->getMock('\CrowdReactive\CloudResizerBundle\CloudResizer\CloudResizer');
        $service->expects($this->once())->method('build')->with('url', 'logo')->willReturn('url');

        $extension = new CloudResizerExtension($service);

        $this->assertCount(1, $extension->getFilters());
        $this->assertEquals('url', $extension->resize('url', 'logo'));
        $this->assertGreaterThan(0, strlen($extension->getName()));
    }
}
