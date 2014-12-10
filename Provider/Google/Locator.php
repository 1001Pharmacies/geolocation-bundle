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
use Meup\Bundle\GeoLocationBundle\Handler\Locator as BaseLocator;
use Meup\Bundle\GeoLocationBundle\Hydrator\Hydrator as BaseHydrator;
use Meup\Bundle\GeoLocationBundle\Hydrator\HydratorInterface;
use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

/**
 *
 */
class Locator extends BaseLocator
{
    /**
     * 
     */
    public function __construct(HydratorInterface $hydrator, HttpClient $http_client, $api_key = null)
    {
        $this->hydrator = $hydrator;
        $this->api_key = $api_key;
        $this->api_endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';
        $this->http_client = $http_client;
    }

    /**
     *
     */
    protected function populate($type, $response)
    {
        if ($response['status']!='OK') {
            throw new \Exception('No results found.');
        }
        return $this
            ->hydrator
            ->hydrate(
                $response['results'],
                $type
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getCoordinates(AddressInterface $address)
    {
        return $this->populate(
            BaseHydrator::TYPE_COORDINATES,
            $this
                ->http_client
                ->get(
                    sprintf(
                        '%s?address=%s&key=%s',
                        $this->api_endpoint,
                        $address->getFullAddress(),
                        $this->api_key
                    )
                )
                ->json()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress(CoordinatesInterface $coordinates)
    {
        return $this->populate(
            BaseHydrator::TYPE_ADDRESS,
            $this
                ->http_client
                ->get(
                    sprintf(
                        '%s?latlng=%d,%d&key=%s',
                        $this->api_endpoint,
                        $coordinates->getLatitude(),
                        $coordinates->getLongitude(),
                        $this->api_key
                    )
                )
                ->json()
        );
    }
}
