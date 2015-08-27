Cache
=====

This bundle is a really simple bundle which enables hard drive caching of controller actions in Symfony 2.


Contributors
------------
AlepH : developper


How to use
----------

in your Controller, just add this lines :

```php
use DLCompare\CacheBundle\Configuration\ActionCache;

class AcmeController extends Controller
{
    /**
     * @ActionCache(maxAge=3600)
     */
    public function yourAction($arg1, $arg2)
```

It will create a cache file in app/cache which will be renderer instead of computing your controller's action if the cache duration hasn't expired.
In this example, the cache will be 3600 seconds long.

Note that a cache will be generated for each possible arguments combination.

Developers notice
-----------------

You can check the EventListener directory for methods to build your own annotations. There are some interesting pieces of code out there to copy / paste :)