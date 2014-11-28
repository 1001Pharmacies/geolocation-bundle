<?php

namespace Meup\Bundle\GeoLocationBundle\Domain\Handler;

use Meup\Bundle\GeoLocationBundle\Domain\Model\LocationInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;

/**
 *
 */
interface LocatorInterface
{
    /**
     * @param LocationInterface $location
     *
     * @return LocationInterface 
     */
    public function locate(LocationInterface $location);

    /**
     * @param AddressInterface $address
     *
     * @return CoordinatesInterface
     */
    public function getCoordinates(AddressInterface $address);

    /**
     * @param CoordinatesInterface $coordinates
     * 
     * @return AddressInterface
     */
    public function getAddress(CoordinatesInterface $coordinates);
}
