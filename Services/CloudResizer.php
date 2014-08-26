<?php

namespace CrowdReactive\CloudResizerBundle\Services;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter;

class CloudResizer {

    /** @var Filter[] */
    protected $filters;

    public function __construct() {
        $this->filters = [];
    }

    /**
     * Set a filter by name
     * @param string $name
     * @param Filter $filter
     */
    public function setFilter($name, Filter $filter) {
        $this->filters[$name] = $filter;
    }

    /**
     * Get a filter by name
     * @param string $name
     * @return Filter
     */
    public function getFilter($name) {
        return $this->filters[$name];
    }

    /**
     * Build a filter URL
     * @param string $url Absolute URL of image to filter
     * @param string $name Filter name
     * @param array|null $options Override options for the filter
     * @return string URL to filter service
     */
    public function build($url, $name, array $options = []) {
        $filter = $this->filters[$name];
        $filter->setParameters(array_merge($filter->getParameters(), $options));
        return $filter->getProvider()->build($filter->getParameters(), $url);
    }

} 