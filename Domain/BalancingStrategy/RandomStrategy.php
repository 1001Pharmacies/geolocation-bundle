<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Domain\BalancingStrategy;

/**
 * Strategy to priorize randomly
 *
 * @author Gilles <gilles@1001pharmacies.com>
 */
class RandomStrategy implements StrategyInterface
{
    /**
     * {inheritdoc}
     */
    public function priorize(array $locators)
    {
        shuffle($locators);

        return $locators;
    }
}
