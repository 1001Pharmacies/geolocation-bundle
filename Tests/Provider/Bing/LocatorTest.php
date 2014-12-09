<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Provider\Bing;

use Meup\Bundle\GeoLocationBundle\Domain\Model\Address;
use Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates;
use Meup\Bundle\GeoLocationBundle\Domain\Factory\AddressFactory;
use Meup\Bundle\GeoLocationBundle\Domain\Factory\CoordinatesFactory;
use Meup\Bundle\GeoLocationBundle\Provider\Bing\Locator as BingLocator;
use Meup\Bundle\GeoLocationBundle\Provider\Bing\Hydrator as BingHydrator;
use Meup\Bundle\GeoLocationBundle\Tests\Provider\LocatorTestCase;

/**
 *
 */
class LocatorTest extends LocatorTestCase
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

        $locator = new BingLocator(
            new BingHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates')
            ),
            $this->getClient('get-coordinates-result.json', __DIR__),
            'api-key'
        );

        $coordinates = $locator->locate($address);

        $this->assertEquals(
            array(43.617723, 3.915721),
            array(
                $coordinates->getLatitude(),
                $coordinates->getLongitude()
            )
        );
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

        $locator = new BingLocator(
            new BingHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Domain\Model\Coordinates')
            ),
            $this->getClient('get-address-result.json', __DIR__),
            'api-key'
        );

        $address = $locator->locate($coordinates);

        $this->assertEquals(
            'Sigean, Aude, France',
            $address->getFullAddress()
        );
    }
}
