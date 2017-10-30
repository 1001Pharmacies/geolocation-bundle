<?php

/**
 * This file is part of the Meup GeoLocation Bundle.
 *
 * (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Meup\Bundle\GeoLocationBundle\Provider\Heredotcom;

use Psr\Log\LoggerInterface;
use GuzzleHttp\Client as HttpClient;
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
    protected $app_code;

    /**
     * @var string
     */
    protected $app_id;

    /**
     * @var string
     */
    protected $api_endpoint;

    /**
     * @var string
     */
    protected $api_reverse_endpoint;

    /**
     * @param HydratorInterface $hydrator
     * @param HttpClient $client
     * @param LoggerInterface $logger
     * @param string $api_key
     * @param string $api_endpoint
     * @throws \Exception
     */
    public function __construct(HydratorInterface $hydrator, HttpClient $client, LoggerInterface $logger, $api_key = null, $api_endpoint)
    {
        parent::__construct($logger);
        $this->hydrator     = $hydrator;
        $this->client       = $client;
        $api_params         = explode(';', $api_key);
        if(count($api_params) != 2) {
            throw new \Exception('Bad Api Key, see doc.');
        }
        $this->app_id       = $api_params[0];
        $this->app_code     = $api_params[1];

        $api_endpoints      = explode(';', $api_endpoint);
        if(count($api_endpoints) != 2) {
            throw new \Exception('Bad Api EndPoints, see doc.');
        }
        $this->api_endpoint = $api_endpoints[0];
        $this->api_reverse_endpoint = $api_endpoints[1];
    }

    /**
     * @param string $type
     * @param Array $response
     * @return \Meup\Bundle\GeoLocationBundle\Model\LocationInterface
     * @throws \Exception
     */
    protected function populate($type, $response)
    {
        $response = json_decode($response->getBody(), true);
        if (count($response['Response']['View']) == 0 || array_key_exists('Result', $response['Response']['View'][0]) === false) {
            throw new \Exception('No results found.');
        }

        // if relevance too low, consided like No Result Found.
        if($response['Response']['View'][0]['Result'][0]['Relevance'] <= 0.50) {
            throw new \Exception('No results found.');
        }

        return $this
            ->hydrator
            ->hydrate(
                $response['Response']['View'],
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
                        '%s?searchtext=%s&app_id=%s&app_code=%s&gen=8maxresults=1',
                        $this->api_endpoint,
                        $address->getFullAddress(),
                        $this->app_id,
                        $this->app_code
                    )
                )
        );

        $this
            ->logger
            ->debug(
                'Locate coordinates by address',
                array(
                    'provider'  => 'heredotcom',
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
                        '%s?prox=%F,%F&mode=retrieveAddresses&app_id=%s&app_code=%s&gen=8&maxresults=1',
                        $this->api_reverse_endpoint,
                        $coordinates->getLatitude(),
                        $coordinates->getLongitude(),
                        $this->app_id,
                        $this->app_code
                    )
                )
        );

        $this
            ->logger
            ->debug(
                'Locate address by coordinates',
                array(
                    'provider'  => 'heredotcom',
                    'address'   => $address->getFullAddress(),
                    'latitude'  => $coordinates->getLatitude(),
                    'longitude' => $coordinates->getLongitude(),
                )
            )
        ;

        return $address;
    }
}
