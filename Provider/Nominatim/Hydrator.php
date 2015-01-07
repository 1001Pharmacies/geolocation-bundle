<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Provider\Nominatim;

use Meup\Bundle\GeoLocationBundle\Hydrator\Hydrator as BaseHydrator;
use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

/**
 *
 */
class Hydrator extends BaseHydrator
{
    /**
     * {@inheritDoc}
     */
    public function populateAddress(AddressInterface $address, Array $data)
    {
        return $address->setFullAddress(
            $data[0]['display_name']
        );
    }

    /**
     * {@inheritDoc}
     */
    public function populateCoordinates(CoordinatesInterface $coordinates, Array $data)
    {
        return $coordinates
            ->setLatitude(
                $data[0]['lat']
            )
            ->setLongitude(
                $data[0]['lon']
            )
        ;
    }
}
