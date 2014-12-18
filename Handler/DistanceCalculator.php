<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Handler;

use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

/**
 *
 */
class DistanceCalculator implements DistanceCalculatorInterface
{
    const EARTH_RADIUS = 6378137;

    /**
     * {@inheritDoc}
     */
    public function getDistance(CoordinatesInterface $from, CoordinatesInterface $to)
    {
        /* script founded here :
           http://www.phpsources.org/scripts459-PHP.htm
         */
        $rlo1 = deg2rad($from->getLongitude());
        $rla1 = deg2rad($from->getLatitude());
        $rlo2 = deg2rad($to->getLongitude());
        $rla2 = deg2rad($to->getLatitude());
        $dlo  = ($rlo2 - $rlo1) / 2;
        $dla  = ($rla2 - $rla1) / 2;
        $a    = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
        $d    = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round((self::EARTH_RADIUS * $d) / 1000, 3);
    }
}
