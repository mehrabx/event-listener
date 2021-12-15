<?php


namespace Mehrabx\eventListenr\Core;


use Closure;
use Exception;
use Mehrabx\EventListenr\Contracts\ListenerInterface;

class Event
{

    /**
     * list of events
     *
     * @var array
     */
    public static $events = [];

    /**
     * add new event to list
     *
     * @param string $event
     *
     * @return void
     */
    public function registerEvent(string $event) :void
    {
        if (!$this->isEventSet($event)) {
            static::$events[$event] = [];
        }
    }

    /**
     * add a listener to the event
     *
     * @param string $event
     * @param Closure|ListenerInterface $listener
     *
     * @return void
     *
     * @throws Exception
     */
    public function attach(string $event, $listener): void
    {
        if (!$this->isEventSet($event)) {
            $this->registerEvent($event);
        }

        if ($listener instanceof Closure || $listener instanceof ListenerInterface) {
            static::$events[$event][] = $listener;
        } else {
            throw new Exception('invalid listener type');
        }

    }

    /**
     * dispatch a event
     *
     * @param string $event
     * @param mixed ...$data
     *
     * @return void
     */
    public function fire(string $event, ...$data): void
    {

        if ($this->isEventSet($event)) {

            foreach (static::$events[$event] as $listener) {
                $this->callMethod($listener, $data);
            }

        }
    }

    /**
     * check event is set
     *
     * @param string $event
     *
     * @return bool
     */
    public function isEventSet(string $event): bool
    {
        return isset(static::$events[$event]);
    }

    /**
     * call update method from listener or cloture function
     *
     * @param Closure|ListenerInterface $listener
     * @param $data
     *
     * @return void
     */
    public function callMethod($listener, $data): void
    {
        switch ($listener) {
            case $listener instanceof Closure :
                call_user_func($listener, ...$data);
                break;
            case $listener instanceof ListenerInterface :
                $listener->update($data);
                break;
        }
    }


}
