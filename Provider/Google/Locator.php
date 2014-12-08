<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Provider\Google;

use GuzzleHttp\Client as HttpClient;
use Meup\Bundle\GeoLocationBundle\Domain\Handler\Locator as BaseLocator;
use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates;

/**
 *
 */
class Locator extends BaseLocator
{
    /**
     * 
     */
    public function __construct(HttpClient $http_client, $api_key = null)
    {
        $this->api_key = $api_key;
        $this->api_endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';
        $this->http_client = $http_client;
    }

    /**
     * {@inheritDoc}
     */
    public function getCoordinates(AddressInterface $address)
    {
        $http_response = $this
            ->http_client
            ->get(
                sprintf(
                    '%s?address=%s&API_KEY=%s',
                    $this->api_endpoint,
                    $address->getFullAddress(),
                    $this->api_key
                )
            )
        ;

        $api_response = $http_response->json();

        if ($api_response['status']=='OK') {
            $results = $api_response['results'];
            
            $latitude  = $results[0]['geometry']['location']['lat'];
            $longitude = $results[0]['geometry']['location']['lng'];

            $coordinates = (new Coordinates())
                ->setLatitude($latitude)
                ->setLongitude($longitude)
            ;

            return $coordinates;
        }

        // https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=API_KEY
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress(CoordinatesInterface $coordinates)
    {
        // https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=API_KEY
    }
}
