<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\CloudImageFilter;
use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

class CloudImageProvider extends Provider implements ProviderInterface
{
    protected $token;

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
        $params = $filter->getParameters();

        // Get first key-pair to use in start
        $keys = array_keys($params);
        $first = array_shift($keys);
        $firstVal = $params[$first];
        unset($params[$first]);

        // Parameters are expressed in the URL as key/value
        ksort($params);
        $query = array_map(function($key, $value) {
            return "$key$value";
        }, array_keys($params), $params);

        // Build the URI
        return rtrim(sprintf("//%s.cloudimage.io/s/%s/%s/%s",
            $this->token,
            $first,
            $firstVal,
            implode(".", $query)
            ), "/")
        . "/"
        . $url;
    }

    public function getFilterInstance()
    {
        return new CloudImageFilter($this);
    }
}