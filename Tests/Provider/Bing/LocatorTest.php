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

use Meup\Bundle\GeoLocationBundle\Model\Address;
use Meup\Bundle\GeoLocationBundle\Model\Coordinates;
use Meup\Bundle\GeoLocationBundle\Factory\AddressFactory;
use Meup\Bundle\GeoLocationBundle\Factory\CoordinatesFactory;
use Meup\Bundle\GeoLocationBundle\Provider\Bing\Locator as BingLocator;
use Meup\Bundle\GeoLocationBundle\Provider\Bing\Hydrator as BingHydrator;
use Meup\Bundle\GeoLocationBundle\Tests\Provider\LocatorTestCase;

/**
 *
 */
class LocatorTest extends LocatorTestCase
{
    /**
     * @param string $result_filename
     *
     * @return BingLocator
     */
    protected function getLocator($result_filename)
    {
        return new BingLocator(
            new BingHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
            ),
            $this->getClient($result_filename, __DIR__),
            'api-key',
            'http://dev.virtualearth.net/REST/v1/Locations/'
        );
    }

    /**
     *
     */
    public function testGetCoordinates()
    {
        $address = new Address();
        $address->setFullAddress(
            '250 rue du Thor, 34000 Montpellier'
        );

        $coordinates = $this
            ->getLocator('get-coordinates-result.json')
            ->locate($address)
        ;

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

        $address = $this
            ->getLocator('get-address-result.json')
            ->locate($coordinates)
        ;

        $this->assertEquals(
            'Sigean, Aude, France',
            $address->getFullAddress()
        );
    }
}
