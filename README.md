# Event Listener

This is slim and powerful library that helps to manage events and listeners in your php application.
You can set events like user created or user deleted then The listeners call when their event fire 

## Requirements


PHP 7.1 or later versions


## Installation

Install via the [Composer](https://getcomposer.org/) utility

```
composer require "mehrabx/eventlistener"
```

## Usage

 Quick start : In this example send email to the user when user sign up

  ```php
use Mehrabx\eventListenr\Contracts\ListenerInterface;
use Mehrabx\eventListenr\Core\Event;

$e = new Event();

$e->registerEvent('userSingUp'); //add userSingUp event to events list

//attach a closure function as a listener to the event 
$e->attach('userSingUp', function () {
    echo 'Send email : welcome new user ';
});

//everywhere in your application fire event , the cloture function run
$e->fire('userSingUp'); //result : Send email to user

  ```

## Set Event
Add an event to events list :
  ```php
use Mehrabx\eventListenr\Core\Event;

$e = new Event();

$e->registerEvent('createUser'); //add creatUser event to events list

  ```


## Attach Listener
You can attach a closure function, or a listener class that implemented ListenerInterface to event

 - Closure Function Listener

  ```php
use Mehrabx\eventListenr\Core\Event;

$e = new Event();

$e->registerEvent('createUser'); 

$e->attach('testEvent', function () { //attach this function to creatUser event
    echo 'hi test';
});
  ```

 - listener class that implemented ListenerInterface

  ```php
use Mehrabx\eventListenr\Core\Event;
use Mehrabx\eventListenr\Contracts\ListenerInterface;

class TestClassListener implements ListenerInterface {

    //update method will call when its event fire 
    public function update($data = null)
    {
       echo 'Hi From TestClassListener';
    }

}


$e = new Event();

$e->registerEvent('createUser'); //add creatUser event to events list

//attach this function to creatUser event
$e->attach('testEvent',new TestClassListener);
  ```


## Fire Event
Fire the event to run its listeners :
  ```php
use Mehrabx\eventListenr\Core\Event;

$e = new Event();

$e->registerEvent('createUser'); 

$e->attach('userSingUp', function () {
    echo 'Send email : welcome new user ';
});

//this method fire the event
$e->fire('userSingUp');
  ```


## Send Data To Listener
You can send data to listener when the event fire :

  ```php
use Mehrabx\eventListenr\Core\Event;
use Mehrabx\eventListenr\Contracts\ListenerInterface;


$e = new Event();

$e->registerEvent('createUser');

//you can use data that send from event fire
$e->attach('testEvent',function($data1,$data2){
    echo "hi ".$data1.$data2;
});

$e->fire('createUser','data1 ','data2 ');
//print : hi data1 data2
  ```
