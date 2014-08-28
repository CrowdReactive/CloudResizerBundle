<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Provider;

use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\ImgixFilter;
use CrowdReactive\CloudResizerBundle\CloudResizer\Filter\FilterInterface;

class ImgixProvider extends Provider implements ProviderInterface
{
    protected $subdomain;
    protected $token;

    public function __construct($subdomain, $token)
    {
        $this->subdomain = $subdomain;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getSubdomain()
    {
        return $this->subdomain;
    }

    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param  FilterInterface $filter
     * @param  string          $url    Should be a relative path to a file
     * @return string          Imgix URL
     */
    public function build(FilterInterface $filter, $url)
    {
        $params = $filter->getParameters();

        $query = array_map(function ($key, $value) {
            return "$key=$value";
        }, array_keys($params), $params);

        // Build the URI
        $url = rtrim(sprintf("//%s.imgix.net/%s?%s",
            $this->subdomain,
            $url,
            implode("&", $query)
            ), "?");

        return $this->signUrl($url);
    }

    private function signUrl($url)
    {
        $parts = parse_url($url);

        $signValue = $this->token.$parts['path'];
        if ($parts['query']) {
            $signValue .= '?'.$parts['query'];
        }

        $signature = md5($signValue);
        $delimiter = strpos($url, "?") !== false ? "&" : "?";

        return $url.$delimiter."s=".$signature;
    }

    public function getFilterInstance()
    {
        return new ImgixFilter($this);
    }
}
