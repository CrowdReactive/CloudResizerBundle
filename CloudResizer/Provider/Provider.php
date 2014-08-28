<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\Filter;
use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

abstract class Provider implements ProviderInterface
{
    abstract public function build(FilterInterface $parameters, $url);

    public function getFilterInstance()
    {
        return new Filter($this);
    }
}
