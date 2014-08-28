<?php
/**
 * Created by PhpStorm.
 * User: Roman Schejbal
 * Date: 19/08/2014
 * Time: 16:43
 */

namespace CrowdReactive\CloudResizerBundle\Twig;

use CrowdReactive\CloudResizerBundle\Services\CloudResizer;

class CloudResizerExtension extends \Twig_Extension
{
    private $cloudResizerService;

    /**
     * @param CloudResizer $imageFilter
     */
    public function __construct(CloudResizer $imageFilter)
    {
        $this->cloudResizerService = $imageFilter;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('cloud_resizer', array($this, 'resize'))
        );
    }

    /**
     * @param $url
     * @param $name
     * @param  array $options
     * @return mixed
     */
    public function resize($url, $name, array $options = [])
    {
        return $this->cloudResizerService->build($url, $name, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cloud_resizer_extension';
    }
}
