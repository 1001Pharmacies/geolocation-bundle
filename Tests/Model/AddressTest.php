<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Model;

use Meup\Bundle\GeoLocationBundle\Model\Address;

/**
 *
 */
class AddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testAccessors()
    {
        $full_address = uniqid();
        $address = new Address();
        $address->setFullAddress($full_address);

        $this->assertEquals(
            $full_address,
            $address->getFullAddress()
        );
    }
}
