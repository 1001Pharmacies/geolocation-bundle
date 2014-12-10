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

/**
 *
 */
class LocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testLocateAddressFromCoordinates()
    {
        $coordinates = $this
            ->getMock('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
        ;
        $address = $this
            ->getMock('Meup\Bundle\GeoLocationBundle\Model\Address')
        ;

        $locator = $this
            ->getMockForAbstractClass('Meup\Bundle\GeoLocationBundle\Handler\Locator')
        ;
        $locator->expects($this->any())
            ->method('getAddress')
            ->will($this->returnValue($address))
        ;

        $this->assertEquals(
            $address,
            $locator->locate($coordinates)
        );
    }

    /**
     *
     */
    public function testLocateCoordinatesFromAddress()
    {
        $coordinates = $this
            ->getMock('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
        ;
        $address = $this
            ->getMock('Meup\Bundle\GeoLocationBundle\Model\Address')
        ;

        $locator = $this
            ->getMockForAbstractClass('Meup\Bundle\GeoLocationBundle\Handler\Locator')
        ;
        $locator->expects($this->any())
            ->method('getCoordinates')
            ->will($this->returnValue($coordinates))
        ;

        $this->assertEquals(
            $coordinates,
            $locator->locate($address)
        );
    }

    /**
     * 
     */
    public function testLocateUnknowLocation()
    {
        $location = $this
            ->getMockForAbstractClass('Meup\Bundle\GeoLocationBundle\Model\Location')
        ;
        $locator = $this
            ->getMockForAbstractClass('Meup\Bundle\GeoLocationBundle\Handler\Locator')
        ;

        $this->assertEquals(
            $locator->locate($location),
            $location
        );
    }
}
