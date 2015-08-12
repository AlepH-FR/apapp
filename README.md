Ap App
======

ApApp is a project for League of Legends (LoL) API Challenge 2.0
It allows you to watch evolution of champions stats (usage, kda, win rate) and items usage from patch 5.11 to patch 5.14.

Contributors
------------
AlepH : developper
Azyphilis: graphisms & design


Architecture
------------

The project is built with 2 separated bundles :

* the main ApAppBundle which provides you have all these fine data analysis provided by the ...
* LoLApiBundle, which can be reused by anyone. 

This last bundle has been built as a configurable module to access LoL APIs and map them into entities.
A larger documentation about this module can be found [**here**][3].

Even if it has limited functionnalities for the moment (only maps data to ORM and not ODM, some missing service on the API), it's highly configurable and evolutive.
Given the delay of this challenge, i didn't had time to do more, but it can be an awesome tool for Symfony 2 users and LoL fans.

Specials Thanks
---------------

* [**DLCompare**][1] for allowing us to use their awesome servers

* [**Symfony 2**][2] for allowing us to work on an awesome framework, even if it's PHP

* League Of Legends for this Challenge, and this game :)

* Our cats for reconforting us when we needed it the most 

[1]: http://www.dlcompare.com
[2]: http://www.symfony.com
[3]: https://github.com/AlepH-FR/apapp/blob/2.8/src/DLCompare/LoLApiBundle/Resources/doc/index.md