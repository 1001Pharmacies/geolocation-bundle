<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Provider\Bing;

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
    public function __construct(HydratorInterface $hydrator, HttpClient $client, $api_key)
    {
        $this->hydrator = $hydrator;
        $this->client = $client;
        $this->api_key = $api_key;
        $this->api_endpoint = 'http://dev.virtualearth.net/REST/v1/Locations/';
    }

    /**
     * {@inheritDoc}
     *
     * @doc http://msdn.microsoft.com/en-us/library/ff701711.aspx
     */
    public function getCoordinates(AddressInterface $address)
    {
        $response = $this
            ->client
            ->get(
                sprintf(
                    '%s%s?o=json&key=%s',
                    $this->api_endpoint,
                    $address->getFullAddress(),
                    $this->api_key
                )
            )
            ->json()
        ;

        return $this
            ->hydrator
            ->hydrate($response, BaseHydrator::TYPE_COORDINATES)
        ;
    }

    /**
     * {@inheritDoc}
     *
     * @doc http://msdn.microsoft.com/en-us/library/ff701710.aspx
     */
    public function getAddress(CoordinatesInterface $coordinates)
    {
        $response = $this
            ->client
            ->get(
                sprintf(
                    '%s%d,%d?o=json&key=%s',
                    $this->api_endpoint,
                    $coordinates->getLatitude(),
                    $coordinates->getLongitude(),
                    $this->api_key
                )
            )
            ->json()
        ;

        return $this
            ->hydrator
            ->hydrate($response, BaseHydrator::TYPE_ADDRESS)
        ;
    }
}
