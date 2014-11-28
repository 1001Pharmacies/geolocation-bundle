<?php

namespace Meup\Bundle\GeoLocationBundle\Domain\Model;

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
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress()
    {
        return $this->address;
    }
}
