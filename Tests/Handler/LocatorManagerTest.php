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
        $manager = new LocatorManager(
            $this->getMock('Meup\Bundle\GeoLocationBundle\Domain\BalancerFactoryInterface')
        );

        $locator = $this
            ->getMockBuilder('Meup\Bundle\GeoLocationBundle\Handler\Locator')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $manager->addLocator($locator);

        $this->assertContains(
            $locator,
            $manager->getLocators()
        );
    }

    /**
     *
     */
    public function testLocate()
    {
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

        $locator
            ->method('getCoordinates')
            ->willReturn($coordinates)
        ;

        $manager = new LocatorManager(
            $this->createBalancerFactory(array($locator))
        );

        $manager->addLocator($locator);

        $this->assertEquals(
            $manager->locate($address),
            $coordinates
        );
    }

    private function createBalancerFactory(array $locators)
    {
        $factory = $this->getMock(
            'Meup\Bundle\GeoLocationBundle\Domain\BalancerFactoryInterface'
        );

        $balancer = $this->getMock(
            'Meup\Bundle\GeoLocationBundle\Domain\BalancerInterface'
        );

        $balancer
            ->expects($this->any())
            ->method('next')
            ->will(
                call_user_func_array(array($this, 'onConsecutiveCalls'), $locators)
            )
        ;

        $factory
            ->expects($this->any())
            ->method('create')
            ->with(
                $this->containsOnlyInstancesOf(
                    'Meup\Bundle\GeoLocationBundle\Handler\LocatorInterface'
                )
            )
            ->willReturn($balancer)
        ;

        return $factory;
    }
}
