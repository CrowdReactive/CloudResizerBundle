<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 16:43
 */

namespace CrowdReactive\ImageFilterBundle\Twig;


use CrowdReactive\ImageFilterBundle\Services\ImageFilter;

class FilterExtension extends \Twig_Extension {

    private $imageFilterService;

    /**
     * @param ImageFilter $imageFilter
     */
    public function __construct(ImageFilter $imageFilter) {
        $this->imageFilterService = $imageFilter;
    }

    /**
     * @return array
     */
    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('image_filter', array($this, 'imageFilter'))
        );
    }

    /**
     * @param $url
     * @param $name
     * @param array $options
     * @return mixed
     */
    public function imageFilter($url, $name, $options = array()) {
        return $this->imageFilterService->build($url, $name, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'image_filter_extension';
    }
}