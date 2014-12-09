<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Provider\Google;

use Meup\Bundle\GeoLocationBundle\Domain\Model\Address;
use Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates;
use Meup\Bundle\GeoLocationBundle\Domain\Factory\AddressFactory;
use Meup\Bundle\GeoLocationBundle\Domain\Factory\CoordinatesFactory;
use Meup\Bundle\GeoLocationBundle\Provider\Google\Locator as GoogleLocator;
use Meup\Bundle\GeoLocationBundle\Provider\Google\Hydrator as GoogleHydrator;

/**
 *
 */
class LocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetCoordinates()
    {
        $address = new Address();
        $address->setFullAddress(
            '250 rue du Thor, 34000 Montpellier'
        );

        $locator = new GoogleLocator(
            new GoogleHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates')
            ),
            $this->getClient('get-coordinates-result.json')
        );

        $coordinates = $locator->locate($address);

        $this->assertEquals(
            array(43.6184254, 3.9160863),
            array(
                $coordinates->getLatitude(),
                $coordinates->getLongitude()
            )
        );
    }

    /**
     *
     */
    public function testGetWithNoResults()
    {
        $address = new Address();
        $address->setFullAddress(
            '250 rue du Thor, 34000 Montpellier'
        );

        $locator = new GoogleLocator(
            new GoogleHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates')
            ),
            $this->getClient('zero-results.json')
        );

        $this->setExpectedException('Exception');

        $coordinates = $locator->locate($address);
    }

    /**
     *
     */
    public function testGetAddress()
    {
        $coordinates = new Coordinates();
        $coordinates
            ->setLatitude(43.6190815)
            ->setLongitude(3.9162419)
        ;

        $locator = new GoogleLocator(
            new GoogleHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates')
            ),
            $this->getClient('get-address-result.json')
        );

        $address = $locator->locate($coordinates);

        $this->assertEquals(
            '640 Rue du Mas de Verchant, 34000 Montpellier, France',
            $address->getFullAddress()
        );
    }
}
