<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Domain;

use Meup\Bundle\GeoLocationBundle\Domain\BalancingStrategy\StrategyInterface;

/**
 * Factory for balancer
 *
 * @author Gilles <gilles@1001pharmacies.com>
 */
class BalancerFactory implements BalancerFactoryInterface
{
    const BALANCER_INTERFACE = 'Meup\Bundle\GeoLocationBundle\Domain\BalancerInterface';

    /**
     * @var \ReflectionClass
     */
    protected $class;

    /**
     * @var StrategyInterface
     */
    protected $strategy;

    /**
     * @param string $classname
     *
     * @throws InvalidArgumentException
     */
    public function __construct($classname, StrategyInterface $strategy)
    {
        $this->class    = new \ReflectionClass($classname);
        $this->strategy = $strategy;

        if (!$this->class->implementsInterface(self::BALANCER_INTERFACE)) {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $locators)
    {
        return $this->class->newInstanceArgs(
            array(
                $locators,
                $this->strategy,
            )
        );
    }
}
