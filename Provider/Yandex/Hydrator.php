<?php

/**
 * This file is part of the Meup GeoLocation Bundle.
 *
 * (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Meup\Bundle\GeoLocationBundle\Provider\Yandex;

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
        $fullAddress = $this->constructAddress($data);

        return $address->setFullAddress($fullAddress);
    }

    /**
     * {@inheritDoc}
     */
    public function populateCoordinates(CoordinatesInterface $coordinates, Array $data)
    {
        $lnglat = explode(' ', $data['GeoObject']['Point']['pos']);
        return $coordinates->setLatitude($lnglat[1])
                           ->setLongitude($lnglat[0]);
    }

    protected function constructAddress($address)
    {

        $fullAddress = $address['GeoObject']['description'];
        $prefix = empty($address['GeoObject']['name']) ? '' : $address['GeoObject']['name'];

        return !empty($prefix) ? ($prefix . ', ' . $fullAddress) : $fullAddress;
    }
}
