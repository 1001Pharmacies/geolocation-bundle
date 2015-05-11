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
 * Balancer
 *
 * @author Gilles <gilles@1001pharmacies.com>
 */
class Balancer implements BalancerInterface
{
    /**
     * @var array
     */
    protected $locators;

    /**
     * @param array             $locators
     * @param StrategyInterface $strategy
     */
    public function __construct(array $locators, StrategyInterface $strategy)
    {
        $this->locators = $strategy->priorize($locators);
    }

    /**
     * {inheritdoc}
     */
    public function next()
    {
        $next = current($this->locators);
        if (false === $next) {
            throw new \OutOfRangeException();
        }

        next($this->locators);

        return $next;
    }
}
