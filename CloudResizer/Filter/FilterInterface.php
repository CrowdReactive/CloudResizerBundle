<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Filter;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;

interface FilterInterface
{
    /**
     * @return array
     */
    public function getParameters();

    /**
     * @param  string $name
     * @return mixed
     */
    public function getParameter($name);

    /**
     * @param  array $parameters
     * @return mixed
     */
    public function setParameters(array $parameters);

    /**
     * @param  string $name
     * @param  mixed  $value
     * @return mixed
     */
    public function setParameter($name, $value);

    /**
     * @return ProviderInterface
     */
    public function getProvider();
}
