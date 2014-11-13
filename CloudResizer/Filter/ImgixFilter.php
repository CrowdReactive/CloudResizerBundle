<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Filter;

class ImgixFilter extends Filter implements FilterInterface
{
    public function setAuto(array $modes)
    {
        $allowedModes = ['format', 'enhance', 'redeye'];
        $modes = array_map('strtolower', $modes);

        $this->parameters['auto'] = implode(",", array_intersect($allowedModes, $modes));
    }
}
