<?php
/**
 * Created by PhpStorm.
 * User: crossborne
 * Date: 19/08/2014
 * Time: 17:06
 */

namespace CrowdReactive\CloudResizerBundle\Services;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;
use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;

class CloudResizer {

    /** @var FilterInterface[] */
    protected $filters;

    public function __construct() {
        $this->filters = [];
    }

    public function setFilter($name, FilterInterface $filter) {
        $this->filters[$name] = $filter;
    }

    public function getFilter($name) {
        return $this->filters[$name];
    }

    public function build($url, $name, array $options = []) {
        $filter = $this->filters[$name];
        $filter->setParameters($options);
        $filter->getProvider()->build($filter, $url);
    }

} 