# CloudResizerBundle

[![Packagist Version](http://img.shields.io/packagist/v/crowdreactive/cloud-resizer-bundle.svg)](http://packagist.org/packages/crowdreactive/cloud-resizer-bundle)
[![Packagist License](http://img.shields.io/packagist/l/crowdreactive/cloud-resizer-bundle.svg)](http://packagist.org/packages/crowdreactive/cloud-resizer-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/619824ac-1647-4852-a371-37d1e30e5202/mini.png)](https://insight.sensiolabs.com/projects/619824ac-1647-4852-a371-37d1e30e5202)
[![Build Status](http://img.shields.io/travis/CrowdReactive/CloudResizerBundle/master.svg)](https://travis-ci.org/CrowdReactive/CloudResizerBundle)
[![Scrutinizer](http://img.shields.io/scrutinizer/g/CrowdReactive/CloudResizerBundle.svg)](https://scrutinizer-ci.com/g/CrowdReactive/CloudResizerBundle)

Provides a wrapper around external image manipulation services. Currently supporting:

*   [CloudImage.io](http://cloudimage.io/)

## Usage

### Standalone

```php
use CrowdReactive\CloudResizerBundle;

$cloudResizer = new CloudResizerBundle\Services\CloudResizer;

// Setup providers
$cloudImage = new CloudResizerBundle\Provider\CloudImage(CLOUDIMAGE_TOKEN);

// Create filters for different purposes
$backgroundThumbnail = new CloudResizerBundle\Filter\RelativeHeight(['height' => 200]);
$backgroundThumbnail->setProvider($cloudImage);
$cloudResizer->setFilter('background_thumb', $backgroundThumbnail);

$cloudResizer->build('https://s3.amazonaws.com/.../uploads/background-123.png', 'background_thumb');
$cloudResizer->build('https://s3.amazonaws.com/.../uploads/background-123.png', 'background_thumb', ['height' => 400]);
```

### Symfony integration

CloudResizer can be used as a Symfony bundle:

```php
// app/AppKernel.php

public function registerBundles() {
    return [
        // ...
        new CrowdReactive\CloudResizerBundle\CrowdReactiveCloudResizerBundle(),
    ];
}
```

```yml
# app/config/config.yml

services:
  cloudresizer.provider.cloudimage:
    class: CrowdReactive\CloudResizerBundle\Provider\CloudImage
    args: [%cloudimage_token%]

crowdreactive_cloudresizerbundle:
  filters:
    background_thumb:
      type: CrowdReactive\CloudResizerBundle\CloudResizer\Filter\RelativeHeight
      provider: @cloudresizer.provider.cloudimage
      parameters:
        height: 50
```

### Twig usage

```django
<img src="{{ page.style.background_image.url|cloudresizer('background_thumb') }}">
<img src="{{ page.style.background_image.url|cloudresizer('background_thumb', {'height': 50}) }}">
```