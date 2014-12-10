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
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MeupGeoLocationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setDefinition(
            'meup_geolocation.address_factory',
            new Definition(
                'Meup\Bundle\GeoLocationBundle\Factory\AddressFactory',
                array(
                    'Meup\Bundle\GeoLocationBundle\Model\Address'
                )
            )
        );

        $container->setDefinition(
            'meup_geolocation.coordinates_factory',
            new Definition(
                'Meup\Bundle\GeoLocationBundle\Factory\CoordinatesFactory',
                array(
                    'Meup\Bundle\GeoLocationBundle\Model\Coordinates'
                )
            )
        );

        $container->setDefinition(
            'meup_geolocation.locator', 
            new Definition(
                'Meup\Bundle\GeoLocationBundle\Handler\LocatorManager'
            )
        );

        $container->setDefinition(
            'meup_geolocation.http_client',
            new Definition(
                'GuzzleHttp\Client'
            )
        );

        foreach ($config['providers'] as $name => $params) {

            $hydrator = sprintf('meup_geolocation.%s_hydrator', $name);

            $container->setParameter(sprintf('geolocation_%s_api_key', $name), 'null');

            $container->setDefinition(
                $hydrator,
                new Definition(
                    $params['hydrator_class'],
                    array(
                        new Reference('meup_geolocation.address_factory'),
                        new Reference('meup_geolocation.coordinates_factory')
                    )
                )
            );

            $definition = new Definition(
                $params['locator_class'],
                array(
                    new Reference($hydrator),
                    new Reference('meup_geolocation.http_client'),
                    $params['api_key']
                )
            );
            $definition->addTag('meup_geolocation.locator');

            $container->setDefinition(
                sprintf('meup_geolocation.%s_locator', $name),
                $definition
            );

        }
    }

}
