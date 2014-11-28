<?php

namespace Meup\Bundle\GeoLocationBundle\Domain\Handler\Google;

use Meup\Bundle\GeoLocationBundle\Domain\Model\LocationInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Handler\LocatorInterface;

/**
 *
 */
class Locator implements LocatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function locate(LocationInterface $location)
    {
        /* */
        if ($location instanceof AddressInterface) {
            return $this->getCoordinates($location);
        } 

        /* */
        if($location instanceof CoordinatesInterface) {
            return $this->getAddress($location);
        }

        return $location;
    }
}
