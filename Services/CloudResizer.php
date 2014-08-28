<?php

namespace CrowdReactive\CloudResizerBundle\Services;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

class CloudResizer {

    /** @var FilterInterface[] */
    protected $filters;

    public function __construct() {
        $this->filters = [];
    }

    /**
     * Set a filter by name
     * @param string $name
     * @param FilterInterface $filter
     */
    public function setFilter($name, FilterInterface $filter) {
        $this->filters[$name] = $filter;
    }

    /**
     * Get a filter by name
     * @param string $name
     * @return FilterInterface
     */
    public function getFilter($name) {
        return $this->filters[$name];
    }

    /**
     * Build a filter URL
     * @param string $url Absolute URL of image to filter
     * @param string $name Filter name
     * @return string URL to filter service
     */
    public function build($url, $name) {
        $filter = $this->filters[$name];
        return $filter->getProvider()->build($filter, $url);
    }

} 