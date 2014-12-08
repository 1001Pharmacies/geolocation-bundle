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
use Meup\Bundle\GeoLocationBundle\Provider\Google\Locator as GoogleLocator;

class LocatorTest extends \PHPUnit_Framework_TestCase
{
    public function testLocate()
    {
        $address = new Address();
        $address->setFullAddress('250 rue du Thor, 34000 Montpellier');

        $locator = new GoogleLocator(new \GuzzleHttp\Client());

        $coordinates = $locator->locate($address);

        $this->assertEquals($coordinates->getLatitude(), 43.6184254);
        $this->assertEquals($coordinates->getLongitude(), 3.9160863);
    }
}
