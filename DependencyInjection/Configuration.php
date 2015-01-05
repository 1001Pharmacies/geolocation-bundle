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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('meup_geolocation');

        $rootNode
            ->children()

                ->arrayNode('address')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('entity_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Model\Address')->end()
                        ->scalarNode('factory_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Factory\AddressFactory')->end()
                    ->end()
                ->end()

                ->arrayNode('coordinates')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('entity_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Model\Coordinates')->end()
                        ->scalarNode('factory_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Factory\CoordinatesFactory')->end()
                    ->end()
                ->end()

                ->arrayNode('handlers')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('distance_calculator')->defaultValue('Meup\Bundle\GeoLocationBundle\Handler\DistanceCalculator')->end()
                        ->scalarNode('locator_manager')->defaultValue('Meup\Bundle\GeoLocationBundle\Handler\LocatorManager')->end()
                    ->end()
                ->end()

                ->arrayNode('providers')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('google')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('api_key')->defaultValue('%geolocation_google_api_key%')->cannotBeEmpty()->end()
                                ->scalarNode('api_endpoint')->defaultValue('https://maps.googleapis.com/maps/api/geocode/json')->end()
                                ->scalarNode('locator_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Provider\Google\Locator')->end()
                                ->scalarNode('hydrator_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Provider\Google\Hydrator')->end()
                            ->end()
                        ->end()
                        ->arrayNode('bing')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('api_key')->defaultValue('%geolocation_bing_api_key%')->cannotBeEmpty()->end()
                                ->scalarNode('api_endpoint')->defaultValue('http://dev.virtualearth.net/REST/v1/Locations/')->end()
                                ->scalarNode('locator_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Provider\Bing\Locator')->end()
                                ->scalarNode('hydrator_class')->defaultValue('Meup\Bundle\GeoLocationBundle\Provider\Bing\Hydrator')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
