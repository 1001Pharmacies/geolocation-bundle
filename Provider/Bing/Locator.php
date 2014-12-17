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

use Guzzle\Http\Client as HttpClient;
use Meup\Bundle\GeoLocationBundle\Handler\Locator as BaseLocator;
use Meup\Bundle\GeoLocationBundle\Hydrator\HydratorInterface;
use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

/**
 * Bing's Locations API
 *
 * @link http://msdn.microsoft.com/en-us/library/ff701715.aspx
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
    public function __construct(HydratorInterface $hydrator, HttpClient $client, $api_key, $api_endpoint)
    {
        $this->hydrator     = $hydrator;
        $this->client       = $client;
        $this->api_key      = $api_key;
        $this->api_endpoint = $api_endpoint;
    }

    /**
     * {@inheritDoc}
     *
     * @link http://msdn.microsoft.com/en-us/library/ff701711.aspx
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
            ->send()
            ->json()
        ;

        return $this
            ->hydrator
            ->hydrate($response, Hydrator::TYPE_COORDINATES)
        ;
    }

    /**
     * {@inheritDoc}
     *
     * @link http://msdn.microsoft.com/en-us/library/ff701710.aspx
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
            ->send()
            ->json()
        ;

        return $this
            ->hydrator
            ->hydrate($response, Hydrator::TYPE_ADDRESS)
        ;
    }
}
