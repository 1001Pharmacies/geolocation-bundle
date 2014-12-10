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
class LocatorManager implements LocatorManagerInterface
{
    /**
     * @var Array
     */
    protected $locators = array();

    /**
     * {@inheritDoc}
     */
    public function getLocators()
    {
        return $this->locators;
    }

    /**
     * {@inheritDoc}
     */
    public function addLocator(LocatorInterface $locator, Array $attributes = array())
    {
        $this->locator[] = $locator;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function locate(LocationInterface $location)
    {
        $key = rand(0, count($this->locators)-1)

        return $this->locators[$key]->locate($location);
    }
}
