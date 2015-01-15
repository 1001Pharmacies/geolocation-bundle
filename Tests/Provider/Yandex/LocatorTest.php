<?php

/**
 * This file is part of the Meup GeoLocation Bundle.
 *
 * (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Meup\Bundle\GeoLocationBundle\Tests\Provider\Yandex;

use Meup\Bundle\GeoLocationBundle\Model\Address;
use Meup\Bundle\GeoLocationBundle\Model\Coordinates;
use Meup\Bundle\GeoLocationBundle\Factory\AddressFactory;
use Meup\Bundle\GeoLocationBundle\Factory\CoordinatesFactory;
use Meup\Bundle\GeoLocationBundle\Provider\Yandex\Locator as YandexLocator;
use Meup\Bundle\GeoLocationBundle\Provider\Yandex\Hydrator as YandexHydrator;
use Meup\Bundle\GeoLocationBundle\Tests\Provider\LocatorTestCase;

/**
 *
 */
class LocatorTest extends LocatorTestCase
{
    /**
     * @param string $result_filename
     *
     * @return YandexLocator
     */
    public function getLocator($result_filename)
    {
        $logger = $this
            ->getMockBuilder('Psr\Log\LoggerInterface')
            ->getMockForAbstractClass()
        ;

        return new YandexLocator(
            new YandexHydrator(
                new AddressFactory('Meup\Bundle\GeoLocationBundle\Model\Address'),
                new CoordinatesFactory('Meup\Bundle\GeoLocationBundle\Model\Coordinates')
            ),
            $this->getClient($result_filename, __DIR__),
            $logger,
            uniqid(), // api_key
            'http://open.mapquestapi.com/geocoding/v1' // endpoint
        );
    }

    /**
     *
     */
    public function testGetCoordinates()
    {
        $address = new Address();
        $address->setFullAddress(
            'rue du Thor, 34000 Montpellier'
        );

        $coordinates = $this
            ->getLocator('get-coordinates-result.json')
            ->locate($address)
        ;

        $this->assertEquals(
            array(43.617539, 3.915586),
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
            '250 rue de Thortank'
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
            ->setLatitude(43.617545)
            ->setLongitude(3.915586)
        ;

        $address = $this
            ->getLocator('get-address-result.json')
            ->locate($coordinates)
        ;

        $this->assertEquals(
            'Rue de Thor, Montpellier, Hérault, Languedoc-Roussillon, France',
            $address->getFullAddress()
        );
    }
}
