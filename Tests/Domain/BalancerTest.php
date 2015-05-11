<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Domain;

use Meup\Bundle\GeoLocationBundle\Domain\Balancer;

/**
 * Tests for Balancer
 *
 * @author Gilles <gilles@1001pharmacies.com>
 */
class BalancerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected static $locators = array('1', '2', '3', '4', '5', '6');

    /**
     * @var array
     */
    protected static $shuffledLocators = array('4', '3', '1', '2', '2', '6');

    public function testNextReturnFirstService()
    {
        $balancer = new Balancer(
            self::$locators,
            $this->createStrategy(self::$locators)
        );

        $this->assertEquals(
            '1',
            $balancer->next()
        );
    }

    private function createStrategy($locators)
    {
        $strategy = $this->getMock(
            'Meup\Bundle\GeoLocationBundle\Domain\BalancingStrategy\StrategyInterface'
        );

        $strategy
            ->expects($this->any())
            ->method('priorize')
            ->willReturn($locators)
        ;

        return $strategy;
    }

    public function testNextReturnNextService()
    {
        $balancer = new Balancer(
            self::$locators,
            $this->createStrategy(self::$locators)
        );

        $balancer->next();
        $balancer->next();

        $this->assertEquals(
            '3',
            $balancer->next()
        );
    }

    public function testNextApplyStrategy()
    {
        $balancer = new Balancer(
            self::$locators,
            $this->createStrategy(self::$shuffledLocators)
        );

        $this->assertEquals(
            '4',
            $balancer->next()
        );
    }

    public function testNextThrowsExceptionIfNoLocatorRemaining()
    {
        $balancer = new Balancer(
            self::$locators,
            $this->createStrategy(self::$locators)
        );

        for ($i = 0; $i < count(self::$locators); $i++) {
            $balancer->next();
        }

        $this->setExpectedException('\OutOfRangeException');

        $balancer->next();
    }
}
