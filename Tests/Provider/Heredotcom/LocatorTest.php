<?php

/**
 * This file is part of the Meup GeoLocation Bundle.
 *
 * (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Meup\Bundle\GeoLocationBundle\Tests\Provider\Heredotcom;

use Meup\Bundle\GeoLocationBundle\Model\Address;
use Meup\Bundle\GeoLocationBundle\Model\Coordinates;
use Meup\Bundle\GeoLocationBundle\Factory\AddressFactory;
use Meup\Bundle\GeoLocationBundle\Factory\CoordinatesFactory;
use Meup\Bundle\GeoLocationBundle\Provider\Heredotcom\Locator as HeredotcomLocator;
use Meup\Bundle\GeoLocationBundle\Provider\Heredotcom\Hydrator as HeredotcomHydrator;
use Meup\Bundle\GeoLocationBundle\Tests\Provider\LocatorTestCase;

/**
 *
 */
class LocatorTest extends LocatorTestCase
{
    /**
     * @param string $result_filename
     *
     * @return HeredotcomLocator
     */
    public function getLocator($result_filename)
    {
        $logger = $this
            ->getMockBuilder('Psr\Log\LoggerInterface')
            ->getMockForAbstractClass()
        ;

        return new HeredotcomLocator(
            new HeredotcomHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
            ),
            $this->getClient($result_filename, __DIR__),
            $logger,
            uniqid() . ';' . uniqid(), // api_key
            'http://geocoder.cit.api.here.com/6.2/geocode.json;http://reverse.geocoder.cit.api.here.com/6.2/reversegeocode.json' // endpoint
        );
    }

    /**
     *
     */
    public function testGetCoordinates()
    {
        $address = new Address();
        $address->setFullAddress(
            '256 rue du Thor Montpellier'
        );

        $coordinates = $this
            ->getLocator('get-coordinates-result.json')
            ->locate($address)
        ;

        $this->assertEquals(
            array(43.6184006, 3.91607),
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
    public function testGetWithLowRelevance()
    {
        $address = new Address();
        $address->setFullAddress(
            '250 rue du Thor, 34000 Montpellier'
        );

        $this->setExpectedException('Exception');

        $this
            ->getLocator('low-relevance.json')
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
            ->setLatitude(43.6184022)
            ->setLongitude(3.9160665)
        ;

        $address = $this
            ->getLocator('get-address-result.json')
            ->locate($coordinates)
        ;

        $this->assertEquals(
            'Rue de Thor, 34000 Montpellier, France',
            $address->getFullAddress()
        );
    }
}
