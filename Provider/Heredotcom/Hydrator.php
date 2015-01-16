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
        $fullAddress = $this->constructAddress($data[0]['Result'][0]['Location']['Address']);
        return $address->setFullAddress($fullAddress);
    }

    /**
     * {@inheritDoc}
     */
    public function populateCoordinates(CoordinatesInterface $coordinates, Array $data)
    {
        $navigationPositions = $data[0]['Result'][0]['Location']['NavigationPosition'][0];
        return $coordinates->setLatitude($navigationPositions['Latitude'])
                           ->setLongitude($navigationPositions['Longitude']);
    }

    protected function constructAddress($address)
    {
        return $address['Label'];
    }
}
