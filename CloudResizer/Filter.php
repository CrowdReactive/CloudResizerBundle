<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;

class Filter
{
    /** @var ProviderInterface */
    protected $provider;

    /** @var array */
    protected $parameters;

    public function __construct(ProviderInterface $provider, $parameters = [])
    {
        $this->provider = $provider;
        $this->parameters = $parameters;
    }

    /**
     * @return Provider\ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }
}