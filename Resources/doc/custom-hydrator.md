Create a custom hydrator
------------------------

customize hydratation mode :
supposed you want to store detailed address informations in your domain model

You should write your own Hydrator method for each used Providers. For example :

```php
namespace Acme\Bundle\AcmeBundle\Hydrator;

use Meup\Bundle\GeoLocationBundle\Hydrator\Hydrator as BaseHydrator;

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