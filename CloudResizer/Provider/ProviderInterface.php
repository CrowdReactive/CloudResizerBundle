<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

interface ProviderInterface
{
    public function build(FilterInterface $filter, $url);
}