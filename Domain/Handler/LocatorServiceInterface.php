<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Domain\Handler;

use Meup\Bundle\GeoLocationBundle\Domain\Model\LocationInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;

/**
 *
 */
interface LocatorServiceInterface
{
    /**
     * @param LocationInterface $location
     *
     * @return LocationInterface 
     */
    public function locate(LocationInterface $location);
}
