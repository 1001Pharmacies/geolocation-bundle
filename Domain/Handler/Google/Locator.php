<?php

namespace Meup\Bundle\GeoLocationBundle\Domain\Handler\Google;

use Meup\Bundle\GeoLocationBundle\Domain\Model\LocationInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Handler\Locator as BaseLocator;

/**
 *
 */
class Locator extends BaseLocator
{
    /**
     * @var string
     */
    protected $api_key;

    /**
     * @param string $api_key
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * {@inheritDoc}
     */
    public function getCoordinates(AddressInterface $address)
    {
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
