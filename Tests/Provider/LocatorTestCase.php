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

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as HttpClient;

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
        $mock = new MockHandler([
            new Response(200, [],
                file_get_contents(
                    $path.
                    DIRECTORY_SEPARATOR.
                    $filename
                ))
        ]);

        $handler = HandlerStack::create($mock);

        $client = new HttpClient(['handler' => $handler]);

        return $client;
    }
}
