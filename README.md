#Event Listener

This is slim and powerful library that helps to manage events and listeners in your php application

##Requirements

PHP 7.1 or later versions


##Installation

Install via the [Composer](https://getcomposer.org/) utility

```
composer require "mehrabx/eventlistener"
```

##Usage

 quick start

  ```php
use Mehrabx\eventListenr\Contracts\ListenerInterface;
use Mehrabx\eventListenr\Core\Event;

$e = new Event();

$e->registerEvent('test'); //add new event to events list

//add a closure function as a listener to event
$e->attach('test', function () {
    echo 'hi test';
});

//everywhere in your application fire event , the cloture function run
$e->fire('test'); //result : hi test


  ```
