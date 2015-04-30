GeoLocation Bundle
==================

[![Build Status](https://secure.travis-ci.org/1001Pharmacies/geolocation-bundle.svg?branch=master)](http://travis-ci.org/1001Pharmacies/geolocation-bundle) [![Total Downloads](https://poser.pugx.org/1001Pharmacies/geolocation-bundle/downloads.png)](https://packagist.org/packages/1001Pharmacies/geolocation-bundle) [![Latest Stable Version](https://poser.pugx.org/1001Pharmacies/geolocation-bundle/v/stable.png)](https://packagist.org/packages/1001Pharmacies/geolocation-bundle)

Provides an abstraction layer for geocoding services. This bundle can be also used to split geocoding's calculation between a set of external geocoding service.

### Supported providers

The following services are included to this bundle :

*  [Google](Resources/doc/provider/google.md)
*  [Bing](Resources/doc/provider/bing.md)
*  [Nominatim](Resources/doc/provider/nominatim.md)
*  [MapQuest](Resources/doc/provider/mapquest.md)
*  [Yandex](Resources/doc/provider/yandex.md)
*  [Here.com](Resources/doc/provider/heredotcom.md)

The the complete documentation to [add you own provider](Resources/doc/custom-provider.md).

Example
-------

### Spatial coordinates and postal address correspondence

#### Coordinates by Address

```php
$address = $container
    ->get('meup_geo_location.address_factory')
    ->create()
    ->setFullAddress('360 rue du thor, 34000 Montpellier')
;

$coordinates = $container
    ->get('meup_geo_location.locator')
    ->locate($address)
;

printf(
    "%s,%s\n",
    $coordinates->getLatitude(),
    $coordinates->getLongitude()
);
// output : 43.6190815,3.9162419
```

The `geolocation-bundle` only provides library ands services. But you can easily [integrate it in your applications](Resources/doc/example.md).

#### Address by Coordinates

```php
$coordinates = $container
    ->get('meup_geo_location.coordinates_factory')
    ->create()
    ->setLatitude(43.6190815)
    ->setLongitude(3.9162419)
;

$address = $container
    ->get('meup_geo_location.locator')
    ->locate($coordinates)
;

print $address->getFullAddress();
// output : 640 Rue du Mas de Verchant, 34000 Montpellier
```

### Distance calculation

When you found two location's coordinates you can also calculate their distance with the distance calculator.

```php
$factory = $container
    ->get('meup_geo_location.coordinates_factory')
;

$paris = $factory
    ->create()
    ->setLatitude(48.856667)
    ->setLongitude(2.350987)
;
$lyon = $factory
    ->create()
    ->setLatitude(45.767299)
    ->setLongitude(4.834329)
;

$distance_paris_lyon = $container
    ->get('meup_geo_location.distance_calculator')
    ->getDistance($paris, $lyon)
;

printf('%d km', $distance_paris_lyon); # 391.613 km
```

Installation
------------

Install the package with [Composer](http://getcomposer.org/) :

```bash
composer require 1001pharmacies/geolocation-bundle
```

Or update the `composer.json` file :

```json
"require": {
    "1001pharmacies/geolocation-bundle": "~1.0"
}
```

Update `app/AppKernel.php` :

```php
$bundles = array(
    // ...
    new Meup\Bundle\GeoLocationBundle\MeupGeoLocationBundle(),
);
```

Setup your `app/config/parameters.yml` with your api keys :

```yaml
parameters:
    # ...
    geo_location_google_api_key:     your_google_api_key
    geo_location_bing_api_key:       your_bing_api_key
    geo_location_nominatim_api_key:  null
    geo_location_mapquest_api_key:   your_mapquest_api_key
    geo_location_yandex_api_key:     null
    geo_location_heredotcom_api_key: your_heredotcom_api_key
```

See detailed [Google](Resources/doc/provider/google.md#create-an-api-key) and [Bing](Resources/doc/provider/bing.md#create-an-api-key) documentation to know how to retrieve api keys.

### Customization

*  [Model](Resources/doc/custom-model.md)
*  [Hydratation](Resources/doc/custom-hydrator.md)
*  [Provider](Resources/doc/custom-provider.md)
*  [Provider balancer](Resources/doc/custom-balancer.md)
*  [Configuration](Resources/doc/configuration.md)
