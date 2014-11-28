GeoLocation Bundle
==================

example :

    /* retrieves coordinates by address */
    use Meup\Bundle\GeoLocationBundle\Domain\Model\Address;

    $locator = $container->get('meup_geolocation.locator');

    $address = new Address();
    $address->setAddress('360 rue du thor, 34000 Montpellier');

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

    print $address->getAddress();
    // output : 640 Rue du Mas de Verchant, 34000 Montpellier
