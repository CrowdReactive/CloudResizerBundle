<?php

namespace CrowdReactive\CloudResizerBundle\CloudResizer\Filter;

class CloudImageFilter extends Filter implements FilterInterface
{
    /**
     * CloudImage provides one transform (resize, crop, etc.) with additional filters
     * @var string
     */
    protected $transformName;

    /**
     * @var string
     */
    protected $transformValue;

    public function getParameters()
    {
        if (is_null($this->transformName)) {
            throw new \BadMethodCallException('Cannot build URL without at least one filter');
        }

        return [$this->transformName => $this->transformValue] + parent::getParameters();
    }

    public function setHeight($height)
    {
        $this->transformName = 'height';
        $this->transformValue = $height;
    }

    public function setWidth($width)
    {
        $this->transformName = 'width';
        $this->transformValue = $width;
    }

    public function setCrop($height, $width)
    {
        $this->transformName = 'crop';
        $this->transformValue = sprintf("%dx%d", $height, $width);
    }

    public function setResizeInBox($height, $width)
    {
        $this->transformName = 'resizeinbox';
        $this->transformValue = sprintf("%dx%d", $height, $width);
    }

    public function setResizeNoPadding($height, $width)
    {
        $this->transformName = 'resizenp';
        $this->transformValue = sprintf("%dx%d", $height, $width);
    }

    public function useCdn()
    {
        $this->transformName = 'cdn';
        $this->transformValue = 'x';
    }

    public function setQuality($quality)
    {
        $this->parameters['q'] = $quality;
    }

    public function setPixelation($pixelSize)
    {
        $this->parameters['fpix'] = $pixelSize;
    }

    public function setFrameRadius($radius)
    {
        $this->parameters['fr'] = $radius;
    }

    public function setFrameColor($colorHex)
    {
        $this->parameters['cf'] = strtolower($colorHex);
    }
}
