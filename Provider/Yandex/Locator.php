<?php

/**
 * This file is part of the Meup GeoLocation Bundle.
 *
 * (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Meup\Bundle\GeoLocationBundle\Provider\Yandex;

use Psr\Log\LoggerInterface;
use Guzzle\Http\Client as HttpClient;
use Meup\Bundle\GeoLocationBundle\Handler\Locator as BaseLocator;
use Meup\Bundle\GeoLocationBundle\Hydrator\HydratorInterface;
use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

/**
 * Mapquest's Geocoding API
 *
 * @link http://open.mapquestapi.com/geocoding/
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
     * @param LoggerInterface $logger
     * @param string $api_key
     * @param string $api_endpoint
     */
    public function __construct(HydratorInterface $hydrator, HttpClient $client, LoggerInterface $logger, $api_key = null, $api_endpoint)
    {
        parent::__construct($logger);
        $this->hydrator     = $hydrator;
        $this->client       = $client;
        $this->api_key      = $api_key;
        $this->api_endpoint = $api_endpoint;
    }

    /**
     * @param string $type
     * @param Array $response
     * @return \Meup\Bundle\GeoLocationBundle\Model\LocationInterface
     * @throws \Exception
     */
    protected function populate($type, $response)
    {
        if ($response['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found']=='0') {
            throw new \Exception('No results found.');
        }

        return $this
            ->hydrator
            ->hydrate(
                $response['response']['GeoObjectCollection']['featureMember'][0],
                $type
            )
            ;
    }

    /**
     * {@inheritDoc}
     */
    public function getCoordinates(AddressInterface $address)
    {
        $coordinates = $this->populate(
            Hydrator::TYPE_COORDINATES,
            $this
                ->client
                ->get(
                    sprintf(
                        '%s/?geocode=%s&lang=en-US&format=json&results=1',
                        $this->api_endpoint,
                        $address->getFullAddress()
                    )
                )
                ->send()
                ->json()
        );

        $this
            ->logger
            ->debug(
                'Locate coordinates by address',
                array(
                    'provider'  => 'yandex',
                    'address'   => $address->getFullAddress(),
                    'latitude'  => $coordinates->getLatitude(),
                    'longitude' => $coordinates->getLongitude(),
                )
            )
        ;

        return $coordinates;
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress(CoordinatesInterface $coordinates)
    {
        $address = $this->populate(
            Hydrator::TYPE_ADDRESS,
            $this
                ->client
                ->get(
                    sprintf(
                        '%s/?geocode=%s,%s&lang=en-US&format=json&results=1',
                        $this->api_endpoint,
                        $coordinates->getLatitude(),
                        $coordinates->getLongitude()
                    )
                )
                ->send()
                ->json()
        );

        $this
            ->logger
            ->debug(
                'Locate address by coordinates',
                array(
                    'provider'  => 'mapquest',
                    'address'   => $address->getFullAddress(),
                    'latitude'  => $coordinates->getLatitude(),
                    'longitude' => $coordinates->getLongitude(),
                )
            )
        ;

        return $address;
    }
}
