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

use Meup\Bundle\GeoLocationBundle\Handler\LocatorManager;

/**
 * 
 */
class LocatorManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testAddLocator()
    {
        $manager = new LocatorManager();

        $locator = $this
            ->getMockBuilder('Meup\Bundle\GeoLocationBundle\Handler\Locator')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $manager->addLocator($locator);

        $this->assertTrue(in_array($locator, $manager->getLocators()));
    }

    /**
     *
     */
    public function testLocate()
    {
        $manager = new LocatorManager();

        $address = $this
            ->getMockBuilder('Meup\Bundle\GeoLocationBundle\Model\Address')
            ->getMock()
        ;
        $coordinates = $this
            ->getMockBuilder('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
            ->getMock()
        ;

        $locator = $this
            ->getMockBuilder('Meup\Bundle\GeoLocationBundle\Handler\Locator')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $locator->method('getCoordinates')->willReturn($coordinates);

        $manager->addLocator($locator);

        $this->assertEquals($manager->locate($address), $coordinates);
    }
}
