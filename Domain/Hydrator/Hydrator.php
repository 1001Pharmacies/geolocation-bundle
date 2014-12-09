<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Domain\Hydrator;

use Meup\Bundle\GeoLocationBundle\Domain\Model\AddressInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Model\CoordinatesInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Factory\AddressFactoryInterface;
use Meup\Bundle\GeoLocationBundle\Domain\Factory\CoordinatesFactoryInterface;

/**
 *
 */
abstract class Hydrator implements HydratorInterface
{
    const TYPE_ADDRESS     = 'address';
    const TYPE_COORDINATES = 'coordinates';

    /**
     * @var AddressFactoryInterface
     */
    protected $address_factory;

    /**
     * @var CoordinatesFactoryInterface
     */
    protected $coordinates_factory;

    /**
     * @param AddressFactoryInterface $address_factory
     * @param CoordinatesFactoryInterface $coordinates_factory
     */
    public function __construct(AddressFactoryInterface $address_factory, CoordinatesFactoryInterface $coordinates_factory)
    {
        $this->address_factory     = $address_factory;
        $this->coordinates_factory = $coordinates_factory;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(Array $data, $entity_name)
    {
        $factory = sprintf('%s_factory', $entity_name);
        $entity  = $this->$factory->create();
        $method  = sprintf('populate%s', ucfirst($entity_name));

        return $this->$method($entity, $data);
    }
}
