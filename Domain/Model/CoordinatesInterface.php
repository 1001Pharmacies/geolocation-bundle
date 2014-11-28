<?php

namespace Meup\Bundle\GeoLocationBundle\Domain\Model;

/**
 *
 */
interface CoordinatesInterface extends LocationInterface
{
    /**
     * @return float
     */
    public function getLatitude();

    /**
     * @return float
     */
    public function getLongitude();
}
