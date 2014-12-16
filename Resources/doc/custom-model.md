Custom Model
============

Use your own model
------------------

You can write your own model classes and then [configure the bundle](configuration.md#model-configuration) to use them.

### With interfaces

```php
namespace Acme\Bundle\AcmeBundle\Entity;

use Meup\Bundle\GeoLocationBundle\Model\AddressInterface;

class Address implements AddressInterface
{
    protected $street_number;
    protected $route;
    protected $locality;
    protected $postal_code;

    public function setStreetNumber($street_number)
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getStreetNumber()
    {
        return $this->street_number;
    }

    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    public function getLocality()
    {
        return $this->getLocality;
    }

    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getPostalCode()
    {
        return $this->postal_code;
    }

    public function getFullAddress()
    {
        return sprintf(
            '%s %s, %s %s',
            $this->getStreetNumber(),
            $this->getRoute(),
            $this->getPostalCode(),
            $this->getLocality()
        );
    }
}
```

### With inheritance

```php
namespace Acme\Bundle\AcmeBundle\Entity;

use Meup\Bundle\GeoLocationBundle\Model\Coordinates as BaseCoordinates;

class Coordinates extends BaseCoordinates
{
    protected $label;

    public function setLabel($label = null)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }
}

```

Customize the factories
-----------------------

You can write your own factories and then [configure the bundle](configuration.md#factories-configuration) to use them.

```php
namespace Acme\Bundle\AcmeBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;

use Acme\Bundle\AcmeBundle\Entity\Address;
use Meup\Bundle\GeoLocationBundle\Factory\AddressFactoryInterface;

class AddressManager implements AddressFactoryInterface
{
    protected $objectManager;
    protected $class;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        $metadata            = $om->getClassMetadata($class);
        $this->objectManager = $om;
        $this->repository    = $om->getRepository($class);
        $this->class         = $metadata->getName();
    }

    public function create(Array $args = array())
    {
        $class = new \ReflectionClass($this->class);

        return $class->newInstanceArgs($params);
    }

    public function update(Address $address, $andFlush = true)
    {
        $this->objectManager->persist($address);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    public function delete(Address $address, $andFlush = true)
    {
        $this->objectManager->remove($address);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}
```
