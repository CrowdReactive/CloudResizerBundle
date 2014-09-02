<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Filter;

use CrowdReactive\CloudResizerBundle\CloudResizer\Provider\ProviderInterface;

class Filter implements FilterInterface
{
    /** @var ProviderInterface */
    protected $provider;

    /** @var array */
    protected $parameters;

    public function __construct(ProviderInterface $provider, $parameters = [])
    {
        $this->provider = $provider;
        $this->setParameters($parameters);
    }

    /**
     * @return ProviderInterface
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
     * @param  string $name
     * @return mixed
     */
    public function getParameter($name)
    {
        return $this->getParameters()[$name];
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = [];
        foreach ($parameters as $name => $value) {
            $this->__set($name, $value);
        }
    }

    /**
     * @param string      $name
     * @param array|mixed $value If value is an array, it will be passed to the setter as arguments
     */
    public function setParameter($name, $value)
    {
        $setter = sprintf('set%s', ucfirst($name));
        if (method_exists($this, $setter)) {
            if (is_array($value)) {
                call_user_func_array([$this, $setter], $value);
            } else {
                call_user_func([$this, $setter], $value);
            }
        } else {
            $this->parameters[$name] = $value;
        }
    }

    /**
     * Call a setter, or set a property
     * @param string $property
     * @param mixed  $value    If value is an array, it will be passed to the setter as arguments
     *
     * Setters should look like "setPropertyName" if the property is "propertyName"
     */
    public function __set($property, $value)
    {
        $this->setParameter($property, $value);
    }

    /**
     * Get a property
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->parameters[$property];
    }
}
