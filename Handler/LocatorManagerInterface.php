<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Handler;

/**
 *
 */
interface LocatorManagerInterface extends LocatorServiceInterface
{
    /**
     * @return Array<LocatorInterface>
     */
    public function getLocators()

    /**
     * @param LocatorInterface $locator
     * @param Array $attributes
     *
     * @return self
     */
    public function addLocator(LocatorInterface $locator, Array $attributes = array())
}
