<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Handler;

use Meup\Bundle\GeoLocationBundle\Model\Coordinates;
use Meup\Bundle\GeoLocationBundle\Handler\DistanceCalculator;

/**
 *
 */
class DistanceCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetDistance()
    {
        $calculator = new DistanceCalculator();

        $paris = new Coordinates();
        $paris
            ->setLatitude(48.856667)
            ->setLongitude(2.350987)
        ;

        $lyon = new Coordinates();
        $lyon
            ->setLatitude(45.767299)
            ->setLongitude(4.834329)
        ;

        $this->assertEquals(
            391.613,
            $calculator->getDistance(
                $paris, $lyon
            )
        );
    }
}
