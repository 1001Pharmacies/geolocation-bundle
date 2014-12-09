<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Domain\Hydrator;

use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;

/**
 *
 */
interface HydratorInterface
{
    /**
     * @param Array $data
     * 
     * @return LocationInterface
     */
    public function hydrate(Array $data, $entity_name);

    /**
     * @param AddressInterface $address
     * @param Array $data
     *
     * @return AddressInterface
     */
    public function populateAddress(AddressInterface $address, Array $data);

    /**
     * @param CoordinatesInterface $coordinates
     * @param Array $data
     *
     * @return CoordinatesInterface
     */
    public function populateCoordinates(CoordinatesInterface $coordinates, Array $data);
}
