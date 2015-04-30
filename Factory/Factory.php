<?php

/**
* This file is part of the Meup GeoLocation Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/geolocation-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\GeoLocationBundle\Factory;

/**
 *
 */
abstract class Factory implements FactoryInterface
{
    const LOCATION_INTERFACE = 'Meup\Bundle\GeoLocationBundle\Model\LocationInterface';

    /**
     * @var \ReflectionClass
     */
    protected $class;

    /**
     * @param string $classname
     *
     * @throws InvalidArgumentException
     */
    public function __construct($classname)
    {
        $this->class = new \ReflectionClass($classname);

        /* */
        if (!$this->class->implementsInterface(self::LOCATION_INTERFACE)) {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $args = array())
    {
        return $this->class->newInstanceArgs($args);
    }

    /**
     * Interface to implements
     *
     * @return string
     */
    // abstract protected function getInterface();
}
