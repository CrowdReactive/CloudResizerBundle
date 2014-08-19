<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Filter;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;

abstract class AbstractFilter implements FilterInterface
{
    protected $parameters;
    protected $provider;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function getProvider()
    {
        return $this->provider;
    }
}