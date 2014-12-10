GeoLocation Bundle
==================

Provides an abstraction layer for geocoding services. This bundle can be also used to split geocoding's calculation between a set of external geocoding service.

### Supported providers

The following services are included to this bundle :

*  [Google](Resources/doc/provider/google.md)
*  [Bing](Resources/doc/provider/bing.md)

The the complete documentation to [add you own provider](Resources/doc/custom-provider.md).

Example
-------

### Spatial coordinates and postal address correspondence

#### Coordinates by Address

```php
    $address = $container
        ->get('meup_geolocation.address_factory')
        ->create()
        ->setFullAddress('360 rue du thor, 34000 Montpellier')
    ;

    $coordinates = $container
        ->get('meup_geolocation.locator')
        ->locate($address)
    ;

    printf(
        "%s,%s\n",
        $coordinates->getLatitude(),
        $coordinates->getLongitude()
    );
    // output : 43.6190815,3.9162419
```

#### Address by Coordinates

```php
    $coordinates = $container
        ->get('meup_geolocation.coordinates_factory')
        ->create()
        ->setLatitude(43.6190815)
        ->setLongitude(3.9162419)
    ;

    $address = $container
        ->get('meup_geolocation.locator')
        ->locate($coordinates)
    ;

    print $address->getFullAddress();
    // output : 640 Rue du Mas de Verchant, 34000 Montpellier
```

### Distance calculation

When you found two location's coordinates you can also calculate their distance with the distance calculator.

```php
    $factory = $container
        ->get('meup_geolocation.coordinates_factory')
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
        ->get('meup_geolocation.distance_calculator')
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
        "1001pharmacies/geolocation-bundle": "1.0"
    }
```

Update `app/AppKernel.php` :

```php
        $bundles = array(
            // ...
            new Meup\Bundle\GeoLocationBundle\MeupGeoLocationBundle(),
        );
```

### Customization

*  [Model](Resources/doc/custom-model.md)
*  [Hydratation](Resources/doc/custom-hydrator.md)
*  [Provider](Resources/doc/custom-provider.md)
