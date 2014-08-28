<?php

namespace CrowdReactive\CloudResizerBundle\Tests\CloudResizer\Filter;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\ImgixFilter;
use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ImgixProvider;

class ImgixFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var ImgixProvider */
    private $imgix;
    /** @var ImgixFilter */
    private $filter;

    public function setUp()
    {
        $this->imgix = new ImgixProvider('subdomain', 'token');
        $this->filter = new ImgixFilter($this->imgix);
    }

    public function testHeight()
    {
        $this->filter->setAuto(['enhance', 'RedEye']);
        $this->assertEquals('//subdomain.imgix.net/logo.png?auto=enhance,redeye&s=829ed17b81998074a89b79b2937e9805', $this->imgix->build($this->filter, 'logo.png'));
    }
}
