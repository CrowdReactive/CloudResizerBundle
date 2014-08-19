<?php

namespace CrowdReactive\ImageFilterBundle\ImageFilter\Filter;

use CrowdReactive\ImageFilterBundle\ImageFilter\Provider\ProviderInterface;

interface FilterInterface
{
    public function setParameters(array $parameters);
    public function getParameters();

    public function setProvider(ProviderInterface $provider);
    public function getProvider();

    public function getName();
}