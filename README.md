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

customize hydratation mode :
supposed you want to store detailed address informations in your domain model


    class Address implements AddressInterface
    {
        protected $street_number;
        protected $route;
        protected $locality;
        protected $postal_code;

        public function setStreetNumber($street_number)
        {
            $this->street_number = $street_number;

            return $this;
        }

        public function getStreetNumber()
        {
            return $this->street_number;
        }

        public function setRoute($route)
        {
            $this->route = $route;

            return $this;
        }

        public function getRoute()
        {
            return $this->route;
        }

        public function setLocality($locality)
        {
            $this->locality = $locality;

            return $this;
        }

        public function getLocality()
        {
            return $this->getLocality;
        }

        public function setPostalCode($postal_code)
        {
            $this->postal_code = $postal_code;

            return $this;
        }

        public function getPostalCode()
        {
            return $this->postal_code;
        }

        public function getFullAddress()
        {
            return sprintf(
                '%s %s, %s %s',
                $this->getStreetNumber(),
                $this->getRoute(),
                $this->getPostalCode(),
                $this->getLocality()
            );
        }
    }

You should write your own Hydrator method for each used Providers. For example :

    class GoogleHydrator extends BaseHydrator
    {
        public function populateAddress(AddressInterface $address, Array $data)
        {
            foreach ($data[0]['address_components'] as $element) {
                switch($element['types'][0]) {
                    case 'street_number':
                        $address->setStreetNumber($element['long_name']);
                        break;
                    case 'route':
                        $address->setRoute($element['long_name']);
                        break;
                    case 'postal_code':
                        $address->setPostalCode($element['long_name']);
                        break;
                    case: 'locality':
                        $address->setLocality($element['long_name']);
                        break;
                }
            }
            return $address;
        }
    }

and then configure your services :

    meup_geolocation.google_hydrator:
        class: GoogleHydrator
        arguments:
            - @meup_geolocation.address_factory
            - @meup_geolocation.coordinates_factory

    meup_geolocation.google_locator:
        class: Meup\Bundle\GeoLocationBundle\Provider\Google\Locator
        arguments: 
            - @meup_geolocation.google_hydrator
            - @meup_geolocation.http_client
            - %google_api_key%
        tags:
            - { name: meup_geolocation.locator }
