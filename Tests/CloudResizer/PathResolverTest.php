<?php

namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer;

use CrowdReactive\CloudResizerBundle\CloudResizer\CloudResizer;
use CrowdReactive\CloudResizerBundle\CloudResizer\PathResolver;

class PathResolverTest extends \PHPUnit_Framework_TestCase
{
    /** @var CloudResizer */
    private $manager;

    const FILTER = 'logo_small';
    const SRC_URL = 'https://www.google.co.uk/images/srpr/logo11w.png';
    const RES_URL = '//example.com/https://www.google.co.uk/images/srpr/logo11w.png';

    public function setUp()
    {
        $this->manager = $this->getMock('CrowdReactive\CloudResizerBundle\CloudResizer\CloudResizer');
        $this->manager->expects($this->once())->method('build')
            ->with(self::SRC_URL, self::FILTER)
            ->willReturn(self::RES_URL);
    }

    public function testPathResolver()
    {
        $resolver = new PathResolver($this->manager, self::FILTER);
        $this->assertEquals(self::RES_URL, $resolver->resolve(self::SRC_URL));
    }
}
