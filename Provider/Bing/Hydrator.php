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
            $data['resourceSets'][0]['resources'][0]['name']
        );
    }

    /**
     * {@inheritDoc}
     */
    public function populateCoordinates(CoordinatesInterface $coordinates, Array $data)
    {
        list($latitude, $longitude) = $data['resourceSets'][0]['resources'][0]['point']['coordinates'];

        return $coordinates
            ->setLatitude($latitude)
            ->setLongitude($longitude)
        ;
    }
}
