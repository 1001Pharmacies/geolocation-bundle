<?php

/**
 * This file is part of the Meup GeoLocation Bundle.
 *
 * (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Meup\Bundle\GeoLocationBundle\Provider\Mapquest;

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
        $fullAddress = $this->constructAddress($data[0]['locations'][0]);

        return $address->setFullAddress($fullAddress);
    }

    /**
     * {@inheritDoc}
     */
    public function populateCoordinates(CoordinatesInterface $coordinates, Array $data)
    {
        return $coordinates->setLatitude($data[0]['locations'][0]['latLng']['lat'])
                           ->setLongitude($data[0]['locations'][0]['latLng']['lng']);
    }

    protected function constructAddress($address)
    {
        $postcodes = explode(';', $address['postalCode']);
        $postcode = $postcodes[0];

        $fullAddress = sprintf('%s %s, %s', $postcode, $address['adminArea5'], $address['adminArea1']);
        $prefix = empty($address['street']) ? '' : $address['street'];

        return !empty($prefix) ? ($prefix . ', ' . $fullAddress) : $fullAddress;
    }
}
