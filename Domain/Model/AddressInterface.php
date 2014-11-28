<?php

namespace Meup\Bundle\GeoLocationBundle\Domain\Model;

/**
 *
 */
interface AddressInterface extends LocationInterface
{
    /**
     * @return string
     */
    public function getAddress();
}
