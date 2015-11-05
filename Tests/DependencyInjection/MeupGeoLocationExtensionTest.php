<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Meup\Bundle\GeoLocationBundle\DependencyInjection\MeupGeoLocationExtension;

/**
 *
 */
class MeupGeoLocationExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MeupGeoLocationExtension
     */
    private $extension;

    /**
     * Root name of the configuration
     *
     * @var string
     */
    private $root;

    /**
     * @return MeupGeoLocationExtension
     */
    protected function getExtension()
    {
        return new MeupGeoLocationExtension();
    }

    /**
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->extension = $this->getExtension();
        $this->root      = "meup_geo_location";
    }

    /**
     *
     */
    public function testGetConfigWithDefaultValues()
    {
        $this->extension->load(array(), $container = $this->getContainer());

        $this->assertTrue($container->hasParameter('geo_location_google_api_key'));
        $this->assertTrue($container->hasParameter('geo_location_bing_api_key'));
    }

    public function testActivatedParam()
    {
        $config = array(
            'meup_geo_location' => array(
                'providers'     => array(
                    'google'    => array(
                        'activated' => false
                    )
                )
            ),
        );

        $this->extension->load($config, $container = $this->getContainer());

        $this->assertFalse($container->hasParameter('geo_location_google_api_key'));
        $this->assertFalse($container->has('meup_geo_location.google_locator'));
    }
}