<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

interface ProviderInterface {
    /**
     * @param FilterInterface $parameters
     * @param string $url
     * @return string
     */
    public function build(FilterInterface $parameters, $url);

    /**
     * @return FilterInterface
     */
    public function getFilterInstance();
}