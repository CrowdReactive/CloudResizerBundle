<?php


namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer\Filter;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\CloudImageFilter;
use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\CloudImageProvider;

/**
 * @todo This tests both the provider and filter - should probably be separated
 */
class CloudImageFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var CloudImageProvider */
    private $cloudImage;
    /** @var CloudImageFilter */
    private $filter;

    public function setUp()
    {
        $this->cloudImage = new CloudImageProvider('token');
        $this->filter = new CloudImageFilter($this->cloudImage);
    }

    public function testHeight()
    {
        $this->filter->setHeight(20);
        $this->assertEquals('//token.cloudimage.io/s/height/20/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testWidth()
    {
        $this->filter->setWidth(10);
        $this->assertEquals('//token.cloudimage.io/s/width/10/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testCrop()
    {
        $this->filter->setCrop(50, 100);
        $this->assertEquals('//token.cloudimage.io/s/crop/50x100/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));

        $this->filter->crop = [75, 20];
        $this->assertEquals('//token.cloudimage.io/s/crop/75x20/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testResizeInBox()
    {
        $this->filter->setResizeInBox(100, 100);
        $this->assertEquals('//token.cloudimage.io/s/resizeinbox/100x100/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testResizeNoPadding()
    {
        $this->filter->setResizeNoPadding(25, 60);
        $this->assertEquals('//token.cloudimage.io/s/resizenp/25x60/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testCdn()
    {
        $this->filter->useCdn();
        $this->assertEquals('//token.cloudimage.io/s/cdn/x/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testReplacements()
    {
        $this->filter->setHeight(20);
        $this->filter->setWidth(40);

        $this->assertEquals('//token.cloudimage.io/s/width/40/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testCdnWithQuality()
    {
        $this->filter->useCdn();
        $this->filter->setQuality(90);

        $this->assertEquals('//token.cloudimage.io/s/cdn/x/q90/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testCdnWithPixelation()
    {
        $this->filter->useCdn();
        $this->filter->setPixelation(15);

        $this->assertEquals('//token.cloudimage.io/s/cdn/x/fpix15/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testCdnWithRoundedFrame()
    {
        $this->filter->useCdn();
        $this->filter->setFrameRadius(300);

        $this->assertEquals('//token.cloudimage.io/s/cdn/x/fr300/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testCdnWithFrameColor()
    {
        $this->filter->useCdn();
        $this->filter->setFrameColor("F0F0F0");

        $this->assertEquals('//token.cloudimage.io/s/cdn/x/cff0f0f0/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    public function testManyParameters()
    {
        $this->filter->useCdn();
        $this->filter->setQuality(90);
        $this->filter->setPixelation(15);
        $this->filter->setFrameRadius(300);
        $this->filter->setFrameColor("F0F0F0");

        $this->assertEquals('//token.cloudimage.io/s/cdn/x/cff0f0f0.fpix15.fr300.q90/' . $this->getUrl(), $this->cloudImage->build($this->filter, $this->getUrl()));
    }

    private function getUrl()
    {
        return 'https://www.google.co.uk/images/srpr/logo11w.png';
    }
}