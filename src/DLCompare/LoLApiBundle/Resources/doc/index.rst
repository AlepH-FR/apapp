LoLApiBundle
============

This bundle has been created for the API Challenge 2.0 of League Of Legends (LoL) / Riot

It consists basically in 3 mains parts :

* the API which enables you to make easy calls to the LoL API
* the ORM entities to store all of that data
* the Importers

Installation
------------

* At the moment you can basically copy this bundle in src/DLCompare/LoLApiBundle
* Update your AppKernel to add "new DLCompare\LoLApiBundle\DLCompareLoLApiBundle()" in your registerBundles method
* Configuration the bundle by updating your config.yml file

```yml
dlcompare_lolapi:
    api:
        key: %lol_api_key%
```

Api
---

Enables you to make api calls to the [**Riot League Of Legends API**][1]
You'll need to have an API Key in order to access this functionnality. You can register for a key [**here**][2]

* Set up the bundle

    * get your api key
    * add a lol_api_key parameter in your parameters.yml file
    * and let's go ! it's as simple as that

* How to call the api ?

```php
$result = $container->get('lolapi')->call($service, $method, array $parameters, array $querystring);
```

The call method returns a json decoded result, it globally means objects you can handle.

It may be possible that all services of League Of Legends aren't supported yet. Don't worry, you can create your own service by implementing new DLCompare\LoLApiBundle\Api\Service\ServiceInterface

* Available services and methods

    * static_data : champion_list, champion_details, item_list, item_details
    * match : details

We'll add more services going further, but given the delay of the challenge, we had to limit ourselves to the needed ones !

* Caching

To reduce the number of API calls, the API service has been developed with a built-in cache. By default it's a FileCache which will create files in your app/cache directory
You can also specify your own cache (if you want to use Memcache instead for example) in your app/config/config.yml file by writing

```yml
dlcompare_lolapi:
    api:
        cache: "My\NameSpaced\Cache"
```

Note that your cache must implement the DLCompare\LoLApiBundle\Api\Cache\CacheInterface
The Bundle is delivered with another "Null" cache which will do... nothing. You can using by using the class DLCompare\LoLApiBundle\Api\Cache\NullCache for the dlcompare_lolapi.api.cache parameter

Entity
------

A basic set of Doctrine ORM Entites have been created so that u can begin working with proper object and avoid having to make too many API calls.
Here are the entites available :

* Champion : champions of LoL
* Game : a given match of LoL
* Item : items in LoL
* Participant : a summoner participation in a LoL Game with stats, champion selected, and so on
* Summoner : LoL players

You can add your own entites, and you can also specify new classes of your own for those object, you just have to override in any yml file those parameters :

* lolapi.entity.champion.class : to override the Champion Entity
* lolapi.manager.champion.class : to override the Champion Repository
* and so on.

You can also disactive this functionnality in your config.yml file. This would not load the model file and hence will not create ORM tables

```yml
dlcompare_lolapi:
    database: none
```

One day, we shall add also the ODM part too !

Importer
--------

The importer basically makes API call and then maps data to your ORM entites

The importer class are built by the ImporterFactory. To access one you have to make a call of this kind :

```php
$champion = $container->get('lolapi.importer.factory')->getImporter('champion')->import(['region' => $region, 'championId' => $championId]);
```

Each importer will need specific data to call the API.
You can also specify your own importers, you just have to override in any yml file those parameters :

* lolapi.importer.champion.class : to override the Champion Importer
* and so on.

You may need to do so if you have your own Entity classes

Configuration Reference
-----------------------

* config.yml

```yml
dlcompare_lolapi:
    api:
        key: %lol_api_key%
    cache: "My\NameSpaced\Cache" (default: DLCompare\LoLApiBundle\Api\Cache\FileCache)
    database: [orm|none] (default: orm)
```

* any service.yml file

```yml
parameters:
    lolapi.entity.champion.class: DLCompare\LoLApiBundle\Entity\Champion
    lolapi.manager.champion.class: DLCompare\LoLApiBundle\Model\ChampionRepository
    lolapi.entity.game.class: DLCompare\LoLApiBundle\Entity\Game
    lolapi.manager.game.class: DLCompare\LoLApiBundle\Model\GameRepository
    lolapi.entity.item.class: DLCompare\LoLApiBundle\Entity\Item 
    lolapi.manager.item.class: DLCompare\LoLApiBundle\Model\ItemRepository
    lolapi.entity.participant.class: DLCompare\LoLApiBundle\Entity\Participant 
    lolapi.manager.participant.class: DLCompare\LoLApiBundle\Model\ParticipantRepository
    lolapi.entity.summoner.class: DLCompare\LoLApiBundle\Entity\Summoner 
    lolapi.manager.summoner.class: DLCompare\LoLApiBundle\Model\SummonerRepository

    lolapi.importer.match.class: DLCompare\LoLApiBundle\Importer\MatchImporter
    lolapi.importer.champion.class: DLCompare\LoLApiBundle\Importer\ChampionImporter
    lolapi.importer.item.class: DLCompare\LoLApiBundle\Importer\ItemImporter
    lolapi.importer.summoner.class: DLCompare\LoLApiBundle\Importer\SummonerImporter

[1]: https://developer.riotgames.com/api/methods
[2]: https://developer.riotgames.com/docs/getting-started