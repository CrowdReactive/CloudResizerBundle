<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Provider;

class CloudImage implements ProviderInterface
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

    public function build(array $parameters, $url)
    {
        // Parameters are expressed in the URL as key/value
        $query = array_map(function($key, $value) {
            return "$key/$value";
        }, array_keys($parameters), $parameters);

        // CloudImage only supports one filter at a time
        if (count($parameters) > 1) {
            throw new \InvalidArgumentException('Only one filter is supported per request');
        }

        // Build the URI
        return sprintf("//%s.cloudimage.io/s/%s/%s",
            $this->token,
            implode("/", $query),
            $url
        );
    }
}