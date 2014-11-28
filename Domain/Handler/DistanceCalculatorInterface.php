<?php

namespace Meup\Bundle\GeoLocationBundle\Domain\Handler;

use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;

/**
 *
 */
interface DistanceCalculatorInterface
{
    /**
     * Calculate the distance between two given points.
     *
     * @param CoordinatesInterface $from
     * @param CoordinatesInterface $to
     *
     * @return integer Number of kilometers between the locations
     */
    public function getDistance(CoordinatesInterface $from, CoordinatesInterface $to);
}
