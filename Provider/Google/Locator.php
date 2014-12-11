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

use Guzzle\Http\Client as HttpClient;
use Meup\Bundle\GeoLocationBundle\Handler\Locator as BaseLocator;
use Meup\Bundle\GeoLocationBundle\Hydrator\HydratorInterface;
use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

/**
 * Google's Geocoding API
 *
 * @link https://developers.google.com/maps/documentation/geocoding/
 */
class Locator extends BaseLocator
{
    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var string 
     */
    protected $api_key;

    /**
     * @var string 
     */
    protected $api_endpoint;

    /**
     * @param HydratorInterface $hydrator
     * @param HttpClient $client
     * @param string $api_key
     * @param string $api_endpoint
     */
    public function __construct(HydratorInterface $hydrator, HttpClient $client, $api_key = null, $api_endpoint)
    {
        $this->hydrator     = $hydrator;
        $this->client       = $client;
        $this->api_key      = $api_key;
        $this->api_endpoint = $api_endpoint;
    }

    /**
     * @param string $type
     * @param Array $response
     *
     * @return \Meup\Bundle\GeoLocationBundle\Model\LocationInterface
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
            Hydrator::TYPE_COORDINATES,
            $this
                ->client
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
            Hydrator::TYPE_ADDRESS,
            $this
                ->client
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
