<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Provider\Nominatim;

use Meup\Bundle\GeoLocationBundle\Model\Address;
use Meup\Bundle\GeoLocationBundle\Model\Coordinates;
use Meup\Bundle\GeoLocationBundle\Factory\AddressFactory;
use Meup\Bundle\GeoLocationBundle\Factory\CoordinatesFactory;
use Meup\Bundle\GeoLocationBundle\Provider\Nominatim\Locator as NominatimLocator;
use Meup\Bundle\GeoLocationBundle\Provider\Nominatim\Hydrator as NominatimHydrator;
use Meup\Bundle\GeoLocationBundle\Tests\Provider\LocatorTestCase;

/**
 *
 */
class LocatorTest extends LocatorTestCase
{
    /**
     * @param string $result_filename
     *
     * @return NominatimLocator
     */
    public function getLocator($result_filename)
    {
        $logger = $this
            ->getMockBuilder('Psr\Log\LoggerInterface')
            ->getMockForAbstractClass()
        ;

        return new NominatimLocator(
            new NominatimHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
            ),
            $this->getClient($result_filename, __DIR__),
            $logger,
            null, // api_key
            'http://nominatim.openstreetmap.org/'
        );
    }

    /**
     *
     */
    public function testGetCoordinates()
    {
        $address = new Address();
        $address->setFullAddress(
            'rue du thor, 34000 montpellier'
        );

        $coordinates = $this
            ->getLocator('get-coordinates-result.json')
            ->locate($address)
        ;

        $this->assertEquals(
            array(43.6171194, 3.9151111),
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
            'impasse fino bricka, 34000 montpellier'
        );

        $this->setExpectedException('Exception');

        $this
            ->getLocator('zero-results.json')
            ->locate($address)
        ;
    }

    /**
     *
     */
    public function testGetAddress()
    {
        $coordinates = new Coordinates();
        $coordinates
            ->setLatitude(43.6014158)
            ->setLongitude(3.8726549)
        ;

        $address = $this
            ->getLocator('get-address-result.json')
            ->locate($coordinates)
        ;

        $this->assertEquals(
            'Rue du Thor, Millénaire, Port Marianne, Montpellier, Hérault, Languedoc-Roussillon, France métropolitaine, 34000;34070;34080;34090, France',
            $address->getFullAddress()
        );
    }
}
