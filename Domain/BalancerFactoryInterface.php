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

/**
 * Interface for Balancer factory
 *
 * @author Gilles <gilles@1001pharmacies.com>
 */
interface BalancerFactoryInterface
{
    /**
     * Create balancer
     *
     * @param array $locators
     *
     * @return BalancerInterface
     */
    public function create(array $locators);
}
