# Set your own geocoder load balancer

To balance geocoders usage, `meup_geo_location.locator` use a `Balancer`.
By default, the balancer just choose a provider randomly.
You can improve this strategy with your own constraints (eg. quotas, service availability or price).

You can do it by changing the balancing strategy.

Create your own Strategy: 

```php
namespace AcmeBundle\BalancingStrategy;

class CustomStrategy implements StrategyInterface
{
    /**
     * {inheritdoc}
     */
    public function priorize(array $locators)
    {
        // Your own priorization logic

        return $locators;
    }
}
```

Create a service from this strategy: 

```yaml
# src/AcmeBundle/resources/services.yml
acme_bundle.custom_strategy:
    class: AcmeBundle\BalancingStrategy\CustomStrategy
    arguments: # ...
```

Set strategy to balancer: 

```yaml
# app/config/config.yml
meup_geo_location:
    balancer:
        strategy: acme_bundle.custom_strategy
```
