<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Model;

use Meup\Bundle\GeoLocationBundle\Model\Coordinates;

/**
 *
 */
class CoordinatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testLatitudeAccessors()
    {
        $latitude = rand();
        $coordinates = new Coordinates();
        $coordinates->setLatitude($latitude);

        $this->assertEquals(
            $latitude,
            $coordinates->getLatitude()
        );
    }

    /**
     *
     */
    public function testLongitudeAccessors()
    {
        $longitude = rand();
        $coordinates = new Coordinates();
        $coordinates->setLongitude($longitude);

        $this->assertEquals(
            $longitude,
            $coordinates->getLongitude()
        );
    }
}
