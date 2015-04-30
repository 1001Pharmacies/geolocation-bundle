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
 * Interface for balancing strategy interface
 *
 * @author Gilles <gilles@1001pharmacies.com>
 */
interface StrategyInterface
{
    /**
     * Priorize locators
     *
     * @param array $locators
     *
     * @return array
     */
    public function priorize(array $locators);
}
