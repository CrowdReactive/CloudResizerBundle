<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

class CloudImage implements ProviderInterface
{
    protected $token;

    protected $filterNames = [
        'CrowdReactive\CloudResizerBundle\CloudResizer\Filter\RelativeHeight' => 'height',
    ];

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function build(FilterInterface $filter, $url)
    {
        // Builds param string "height=200/width=100"
        $parameters = [];
        foreach ($filter->getParameters() as $key => $value) {
            $parameters[] = "$key=$value";
        }
        $parameters = implode("/", $parameters);

        $cloudImageUrl = sprintf("//%s.cloudimage.io/s/%s/%s/%s",
            $this->token,
            $this->getFilterName($filter),
            $parameters,
            $url
        );

        return $cloudImageUrl;
    }

    protected function getFilterName(FilterInterface $filter)
    {
        $name = get_class($filter);
        if (!array_key_exists($name, $this->filterNames)) {
            throw new \Exception('Unsupported filter ' . $name);
        }

        return $this->filterNames[$name];
    }
}