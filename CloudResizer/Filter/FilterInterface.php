<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Filter;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;

interface FilterInterface
{
    public function setParameters(array $parameters);
    public function getParameters();

    public function setProvider(ProviderInterface $provider);
    /** @return ProviderInterface */
    public function getProvider();

    public function getName();
}