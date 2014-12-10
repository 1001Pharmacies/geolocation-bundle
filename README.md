GeoLocation Bundle
==================

Example
-------

### Spatial coordinates and postal address correspondence

#### Coordinates by Address

```php
    use Meup\Bundle\GeoLocationBundle\Model\Address;

    $locator = $container->get('meup_geolocation.locator');

    $address = new Address();
    $address->setFullAddress('360 rue du thor, 34000 Montpellier');

    $coordinates = $locator->locate($address);

    printf(
        "%s,%s\n",
        $coordinates->getLatitude(),
        $coordinates->getLongitude()
    );
    // output : 43.6190815,3.9162419
```

#### Address by Coordinates

```php
    use Meup\Bundle\GeoLocationBundle\Model\Coordinates;

    $locator = $container->get('meup_geolocation.locator');

    $coordinates = new Coordinates();
    $coordinates
        ->setLatitude(43.6190815)
        ->setLongitude(3.9162419)
    ;

    $address = $locator->locate($coordinates);

    print $address->getFullAddress();
    // output : 640 Rue du Mas de Verchant, 34000 Montpellier
```

### Distance calculation

```php
    $paris = (new Coordinates())
        ->setLatitude(48.856667)
        ->setLongitude(2.350987)
    ;

    $lyon = (new Coordinates())
        ->setLatitude(45.767299)
        ->setLongitude(4.834329)
    ;

    $distance_paris_lyon = $this
        ->get('meup_geolocation.distance_calculator')
        ->getDistance($paris, $lyon)
    ;

    printf('%d km', $distance_paris_lyon); # 391.613 km
```

Installation
------------

Install the package with composer :

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