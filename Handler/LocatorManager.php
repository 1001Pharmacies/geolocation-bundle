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

use Meup\Bundle\GeoLocationBundle\Model\LocationInterface;
use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Model\CoordinatesInterface;

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
        $this->locators[] = $locator;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function locate(LocationInterface $location)
    {
        $key     = rand(0, count($this->locators)-1);
        $locator = $this->locators[$key];
        $result  = $locator->locate($location);

        if ($location instanceof AddressInterface) {
        }

        if ($location instanceof CoordinatesInterface) {
            $this
                ->logger
                ->debug(
                    'Locate address by coordinates',
                    array(
                        'address'   => $result->getFullAddress(),
                        'latitude'  => $location->getLatitude(),
                        'longitude' => $location->getLongitude(),
                    )
                )
            ;
        }

        return $result;
    }
}
