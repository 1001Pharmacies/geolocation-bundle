<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Factory;

use Meup\Bundle\GeoLocationBundle\Domain\BalancerFactory;

/**
 * Tests for Balancer factory
 *
 * @author Gilles <gilles@1001pharmacies.com>
 */
class BalancerFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $class = 'Meup\Bundle\GeoLocationBundle\Domain\Balancer';

    public function testFactoryInterface()
    {
        $factory = new BalancerFactory(
            $this->class,
            $this->getMock('Meup\Bundle\GeoLocationBundle\Domain\BalancingStrategy\StrategyInterface')
        );

        $this->assertInstanceOf(
            'Meup\Bundle\GeoLocationBundle\Domain\BalancerFactoryInterface',
            $factory
        );
    }

    public function testCreate()
    {
        $factory = new BalancerFactory(
            $this->class,
            $this->getMock('Meup\Bundle\GeoLocationBundle\Domain\BalancingStrategy\StrategyInterface')
        );

        $this->assertInstanceOf(
            $this->class,
            $factory->create(array(1, 2, 3))
        );
    }

    public function testCreateAssumingException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $factory = new BalancerFactory(
            'stdClass',
            $this->getMock('Meup\Bundle\GeoLocationBundle\Domain\BalancingStrategy\StrategyInterface')
        );
    }
}
