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
        $distance_calculator = $this->getMockForAbstractClass(
            'Meup\Bundle\GeoLocationBundle\Handler\DistanceCalculator'
        );

        $this->assertEquals(
            391.613,
            $distance_calculator->getDistance(
                (new Coordinates())
                    ->setLatitude(48.856667)
                    ->setLongitude(2.350987)
                ,
                (new Coordinates())
                    ->setLatitude(45.767299)
                    ->setLongitude(4.834329)
            )
        );
    }
}
