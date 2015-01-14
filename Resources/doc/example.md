Geolocation app example
=======================

Suposed that you want to create an application where your users fill a form with their address an then could find the given GPS coordinates.

First, you have to design a tiny html form :

```twig
{# app/Resources/views/default/index.html.twig #}

{% extends 'base.html.twig' %}

{% block body %}

{% if coordinates %}
<p>
  <b>latitude</b> : {{ coordinates.latitude }} <br>
  <b>longitude</b> : {{ coordinates.longitude }}
</p>
{% endif %}

<form method="GET">
  <fieldset>
    <legend>GeoLocation</legend>
    <p>
      <label for="service">Service</label>
      <select id="service" name="service">
        <option{% if service == ''%} selected{% endif %}>Random</option>
        <option value="google"{% if service == 'google'%} selected{% endif %}>Google</option>
        <option value="bing"{% if service == 'bing'%} selected{% endif %}>Bing</option>
        <option value="nominatim"{% if service == 'nominatim'%} selected{% endif %}>Nominatim</option>
      </select>
    </p>
    <p>
      <label for="address">Address</label><br>
      <textarea id="address" name="address" required>{{ address.fulladdress }}</textarea>
    </p>
    <p>
      <a href="{{ path('homepage') }}">Cancel</a>
      <button type="submit">Find coordinates</button>
    </p>
  </fieldset>
</form>

{% endblock %}
```

And then, use the `geolocation-bundle` in your app controller :

```php
# src/AppBundle/Controller/DefaultController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $query   = $this->get('request')->query;
        $service = $query->get('service');
        $address = $this->get('meup_geo_location.address_factory')->create();
        $coords  = null;
        $locator = $this->get(
            sprintf(
                'meup_geo_location.%slocator',
                $service ? sprintf('_%', $service): null
            )
        );

        if ($query->has('address')) {
            $address->setFullAddress($query->get('address'));
            $coords = $locator->locate($address);
        }

        return $this->render(
            'default/index.html.twig',
            [
                'address'     => $address,
                'coordinates' => $coords,
                'service'     => $service,
            ]
        );
    }
}
```
