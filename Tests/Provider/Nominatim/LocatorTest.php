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
        return new NominatimLocator(
            new NominatimHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
            ),
            $this->getClient($result_filename, __DIR__),
            null, // api_key
            'https://maps.googleapis.com/maps/api/geocode/json'
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
            ->setLatitude(43.6190815)
            ->setLongitude(3.9162419)
        ;

        $address = $this
            ->getLocator('get-address-result.json')
            ->locate($coordinates)
        ;

        $this->assertEquals(
            '640 Rue du Mas de Verchant, 34000 Montpellier, France',
            $address->getFullAddress()
        );
    }
}
