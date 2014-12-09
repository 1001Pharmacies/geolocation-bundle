Create a custom hydrator
------------------------

customize hydratation mode :
supposed you want to store detailed address informations in your domain model

```php
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
```

You should write your own Hydrator method for each used Providers. For example :

```php
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
```

and then configure your services :

```yaml
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
```