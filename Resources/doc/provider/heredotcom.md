Here.com API
=============

Doc
---

Go to [https://developer.here.com/rest-apis/documentation/geocoder/](https://developer.here.com/rest-apis/documentation/geocoder/) to create a Nokia account and register your application.

Api Key must be composed of your AppId and AppCode separated with semicolon.

EndPoint must be composed of GeoCode Endpoint and Reverse GeoCode Endpoint separated with semicolon :

```yaml
parameters:
    # ...
    api_key: {your App Id};{your App Code}
    endpoint: http://{GeoCode Endpoint (ex: http://geocode/api/)};{GeoCode Reverse Endpoint (ex: http://reverse.geocode/api)}
```

Usage limit
-----------

The courtesy limit is available [100,000 requests/month](https://developer.here.com/get-started#/10134035).