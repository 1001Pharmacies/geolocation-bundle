<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Handler;

use Meup\Bundle\GeoLocationBundle\Model\LocationInterface;
use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

/**
 *
 */
interface LocatorInterface extends LocatorServiceInterface
{
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
