<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Model;

/**
 *
 */
class Address extends Location implements AddressInterface
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @param string $address
     *
     * @return self
     */
    public function setFullAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFullAddress()
    {
        return $this->address;
    }
}
