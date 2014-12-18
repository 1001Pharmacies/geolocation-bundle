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
use Meup\Bundle\GeoLocationBundle\DependencyInjection\LocatorCompilerPass;

/**
 *
 */
class LocatorCompilerPassTest extends \PHPUnit_Framework_TestCase
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
        $this->root      = "meup_geolocation";
    }

    /**
     *
     */
    public function testProcess()
    {
        $this->extension->load(array(), $container = $this->getContainer());

        $compiler = new LocatorCompilerPass();

        $compiler->process($container);

    }
}