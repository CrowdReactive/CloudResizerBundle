<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer;

/**
 * A helper class for encapsulating a filter
 */
class PathResolver
{
    /** @var CloudResizer */
    protected $manager;

    /** @var string */
    protected $filterName;

    /**
     * @param CloudResizer $manager Manager instance
     * @param string $filterName Name of the filter to apply
     */
    public function __construct(CloudResizer $manager, $filterName)
    {
        $this->manager = $manager;
        $this->filterName = $filterName;
    }

    /**
     * @param string $path URL to apply filter to
     * @return string Built URL
     */
    public function resolve($path)
    {
        return $this->manager->build($path, $this->filterName);
    }
}
