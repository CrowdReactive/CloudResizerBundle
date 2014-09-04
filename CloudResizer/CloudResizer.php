<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

class CloudResizer
{
    /** @var FilterInterface[] */
    protected $filters;

    /** @var bool Allows for disabling URLs in development */
    protected $enabled;

    public function __construct()
    {
        $this->filters = [];
        $this->enabled = true;
    }

    /**
     * Set a filter by name
     * @param string          $name
     * @param FilterInterface $filter
     */
    public function setFilter($name, FilterInterface $filter)
    {
        $this->filters[$name] = $filter;
    }

    /**
     * Get a filter by name
     * @param  string          $name
     * @return FilterInterface
     */
    public function getFilter($name)
    {
        return $this->filters[$name];
    }

    /**
     * Build a filter URL
     * @param  string $url  Absolute URL of image to filter
     * @param  string $name Filter name
     * @return string URL to filter service
     */
    public function build($url, $name)
    {
        if ($this->enabled) {
            $filter = $this->filters[$name];

            return $filter->getProvider()->build($filter, $url);
        }

        return $url;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
