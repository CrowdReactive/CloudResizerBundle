<?php

namespace CrowdReactive\ImageFilterBundle\ImageFilter\Provider;

use CrowdReactive\ImageFilterBundle\ImageFilter\Filter\FilterInterface;

interface ProviderInterface
{
    public function build(FilterInterface $filter, $url);
}