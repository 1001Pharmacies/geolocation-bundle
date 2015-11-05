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

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

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
        $config = $this->processConfiguration(
            new Configuration(),
            $configs
        );

        $factories = $this->loadFactories($config, $container);
        $this->loadBalancer($config, $container);
        $this->loadHandlers($config, $container);
        $this->loadProviders($config, $container, $factories);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     *
     * @return Array<Definition>
     */
    protected function loadFactories(array $config, ContainerBuilder $container)
    {
        $result = array();

        foreach (array('address', 'coordinates') as $entity) {
            $result[] = $container->setDefinition(
                sprintf('meup_geo_location.%s_factory', $entity),
                new Definition(
                    $config[$entity]['factory_class'],
                    array(
                        $config[$entity]['entity_class'],
                    )
                )
            );
        }

        return $result;
    }

    /**
     * Load balancer service
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function loadBalancer(array $config, ContainerBuilder $container)
    {
        $container->register(
            'meup_geo_location.balancer.random_strategy',
            'Meup\Bundle\GeoLocationBundle\Domain\BalancingStrategy\RandomStrategy'
        );

        $container->setAlias(
            'meup_geo_location.balancer.strategy',
            $config['balancer']['strategy']
        );

        $container
            ->register(
                'meup_geo_location.balancer_factory.default',
                'Meup\Bundle\GeoLocationBundle\Domain\BalancerFactory'
            )
            ->addArgument(
                'Meup\Bundle\GeoLocationBundle\Domain\Balancer'
            )
            ->addArgument(
                new Reference('meup_geo_location.balancer.strategy')
            )
        ;

        $container->setAlias(
            'meup_geo_location.balancer_factory',
            $config['balancer']['factory']
        );
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     *
     * @return void
     */
    protected function loadHandlers(array $config, ContainerBuilder $container)
    {
        $container->setDefinition(
            'meup_geo_location.distance_calculator',
            new Definition($config['handlers']['distance_calculator'])
        );

        $container->setDefinition(
            'meup_geo_location.locator',
            new Definition(
                $config['handlers']['locator_manager'],
                array(
                    new Reference('meup_geo_location.balancer_factory'),
                    new Reference('logger'),
                )
            )
        );
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     *
     * @return Array<Definition>
     */
    protected function loadProviders(array $config, ContainerBuilder $container, $model)
    {
        $http_client = $container->setDefinition(
            'meup_geo_location.http_client',
            new Definition(
                'Guzzle\Http\Client'
            )
        );

        $result = array();

        foreach ($config['providers'] as $name => $params) {
            if ($params['activated']) {
                $result[] = $this->loadProvider(
                    $container,
                    $name,
                    $params,
                    $http_client,
                    $model
                );
            }
        }

        return $result;
    }

    /**
     * @param ContainerBuilder $container
     * @param string $name
     * @param array $params
     * @param Definition $http_client
     * @param Array<Definition> $factories
     *
     * @return Definition
     */
    protected function loadProvider(ContainerBuilder $container, $name, array $params, Definition $http_client, array $factories)
    {
        $container->setParameter(
            sprintf('geo_location_%s_api_key', $name),
            'null'
        );

        $hydrator = $container->setDefinition(
            sprintf('meup_geo_location.%s_hydrator', $name),
            new Definition(
                $params['hydrator_class'],
                $factories
            )
        );

        $definition = new Definition(
            $params['locator_class'],
            array(
                $hydrator,
                $http_client,
                new Reference('logger'),
                $params['api_key'],
                $params['api_endpoint']
            )
        );

        $definition->addTag('meup_geo_location.locator');

        $container->setDefinition(
            sprintf('meup_geo_location.%s_locator', $name),
            $definition
        );

        return $definition;
    }
}
