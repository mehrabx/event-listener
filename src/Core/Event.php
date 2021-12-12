<?php


namespace Mehrabx\eventListenr\Core;


use Closure;
use Exception;
use Mehrabx\EventListenr\Contracts\ObserverInterface;

class Event
{

    public static $events = [];


    public function registerEvent($event): void
    {
        if (!!$this->isEventSet($event)) {
            array_push(static::$events, $event);
        }
    }

    public function attach($event, $observer): void
    {
        if (!$this->isEventSet($event)) {
            $this->registerEvent($event);
        }

        if ($observer instanceof Closure || $observer instanceof ObserverInterface) {
            static::$events[$event][] = $observer;
        } else {
            throw new Exception('invalid listener type');
        }

    }


    public function fire($event): void
    {
        if ($this->isEventSet($event)) {

            foreach (static::$events[$event] as $observer) {
                $this->callMethod($observer);
            }

        }
    }

    public function isEventSet($event): bool
    {
        return isset(static::$events[$event]);
    }


    public function callMethod($observer): void
    {
        switch ($observer) {
            case $observer instanceof Closure :
                call_user_func($observer);
                break;
            case $observer instanceof ObserverInterface :
                $observer->update();
                break;
        }
    }


}
