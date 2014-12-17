<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Tests\Provider;

/**
 *
 */
class LocatorTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function getClient($filename, $path = __DIR__)
    {
        $response = $this
            ->getMockBuilder('Guzzle\Http\Message\Response')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $response
            ->method('json')
            ->willReturn(
                json_decode(
                    file_get_contents(
                        $path.
                        DIRECTORY_SEPARATOR.
                        $filename
                    ),
                    true
                )
            )
        ;

        $request = $this
            ->getMockBuilder('Guzzle\Http\Message\Request')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $request
            ->method('send')
            ->willReturn($response)
        ;

        $client = $this
            ->getMockBuilder('Guzzle\Http\Client')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $client
            ->method('get')
            ->willReturn($request)
        ;

        return $client;
    }
}
