Configuration
=============

Custom Model
------------

Configure your [custom model](custom-model.md) :

### Model configuration

```yaml
meup_geo_location:
    address:
        entity_class: Acme\Bundle\AcmeBundle\Entity\Address
    coordinates:
        entity_class: Acme\Bundle\AcmeBundle\Entity\Coordinates
```

### Factories configuration

```yaml
meup_geo_location:
    address:
        factory_class: Acme\Bundle\AcmeBundle\Doctrine\AddressManager
    coordinates:
        factory_class: Acme\Bundle\AcmeBundle\Doctrine\CoordinatesManager
```

Custom Hydrator
---------------



Configuration reference
-----------------------

The `app/config/parameters.yml` will contains your API keys :

```yaml
parameters:
    # ...
    geo_location_google_api_key:    your_google_api_key
    geo_location_bing_api_key:      your_bing_api_key
    geo_location_mapquest_api_key:   your_mapquest_api_key
```

you can configure your `app/config/config.yml` with the following

```yaml
meup_geo_location:
    address:
        entity_class:        Meup\Bundle\GeoLocationBundle\Model\Address
        factory_class:       Meup\Bundle\GeoLocationBundle\Factory\AddressFactory
    coordinates:
        entity_class:        Meup\Bundle\GeoLocationBundle\Model\Coordinates
        factory_class:       Meup\Bundle\GeoLocationBundle\Factory\CoordinatesFactory
    handlers:
        distance_calculator: Meup\Bundle\GeoLocationBundle\Handler\DistanceCalculator
        locator_manager:     Meup\Bundle\GeoLocationBundle\Handler\LocatorManager
    providers:
        google:
            api_key:         %geo_location_google_api_key%
            api_endpoint:    https://maps.googleapis.com/maps/api/geocode/json
            locator_class:   Meup\Bundle\GeoLocationBundle\Provider\Google\Locator
            hydrator_class:  Meup\Bundle\GeoLocationBundle\Provider\Google\Hydrator
        bing:
            api_key:         %geo_location_bing_api_key%
            api_endpoint:    http://dev.virtualearth.net/REST/v1/Locations/
            locator_class:   Meup\Bundle\GeoLocationBundle\Provider\Bing\Locator
            hydrator_class:  Meup\Bundle\GeoLocationBundle\Provider\Bing\Hydrator
        nominatim:
            api_key:         %geo_location_nominatim_api_key%
            api_endpoint:    http://nominatim.openstreetmap.org/
            locator_class:   Meup\Bundle\GeoLocationBundle\Provider\Nominatim\Locator
            hydrator_class:  Meup\Bundle\GeoLocationBundle\Provider\Nominatim\Hydrator
        mapquest:
            api_key:         %geo_location_mapquest_api_key%
            api_endpoint:    http://open.mapquestapi.com/geocoding/v1
            locator_class:   Meup\Bundle\GeoLocationBundle\Provider\Mapquest\Locator
            hydrator_class:  Meup\Bundle\GeoLocationBundle\Provider\Mapquest\Hydrator
```
