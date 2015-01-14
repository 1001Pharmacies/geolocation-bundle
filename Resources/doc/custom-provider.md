Create a new GeoCoding Provider
-------------------------------

create your own locator provider :

```yaml
    # services.yml
    meup_geo_location.example_locator:
        class: Acme\GeoCoding\Locator
        arguments: # ...
        tags:
            - { name: meup_geo_location.locator }
```

```php
    # vendor/Acme/Locator.php

    namespace Acme\GeoCoding;

    use Meup\Bundle\GeoLocationBundle\Domain\Handler\Locator as BaseLocator
    use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
    use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;

    class Locator extends BaseLocator
    {
        public function getCoordinates(AddressInterface $address)
        {}

        public function getAddress(CoordinatesInterface $coordinates)
        {}
    }
```