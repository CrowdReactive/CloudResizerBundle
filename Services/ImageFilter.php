<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 17:06
 */

namespace CrowdReactive\ImageFilterBundle\Services;


use CrowdReactive\ImageFilterBundle\ImageFilter\Filter\FilterInterface;
use CrowdReactive\ImageFilterBundle\ImageFilter\Provider\ProviderInterface;

class ImageFilter {

    protected $providers;
    protected $filters;

    public function __construct() {
        $this->providers = [];
        $this->filters = [];
    }

    public function setProvider($name, ProviderInterface $provider)
    {
        $this->providers[$name] = $provider;
    }

    public function getProvider($name)
    {
        return $this->providers[$name];
    }

    public function setFilter($name, FilterInterface $filter)
    {
        $this->filters[$name] = $filter;
    }

    public function getFilter($name)
    {
        return $this->filters[$name];
    }


    public function build($url, $name, array $options) {

    }

} 