GeoLocation Bundle
==================

example :

    /* retrieves coordinates by address */
    use Meup\Bundle\GeoLocationBundle\Domain\Model\Address;

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

reverse :

    /* retrieves address by coordinates */
    use Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates;

    $locator = $container->get('meup_geolocation.locator');

    $coordinates = new Coordinates();
    $coordinates
        ->setLatitude(43.6190815)
        ->setLongitude(3.9162419)
    ;

    $address = $locator->locate($coordinates);

    print $address->getFullAddress();
    // output : 640 Rue du Mas de Verchant, 34000 Montpellier



create your own locator provider :

    # services.yml
    
    meup_geolocation.example_locator:
        class: Acme\GeoCoding\Locator
        arguments: # ...
        tags:
            - { name: meup_geolocation.locator }


    <?php 
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
