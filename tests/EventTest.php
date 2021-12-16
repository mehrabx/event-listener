<?php


namespace Mehrabx\eventListenr\Tests;


use Mehrabx\eventListenr\Contracts\ListenerInterface;
use Mehrabx\eventListenr\Core\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    private $eventClass;
    static $listenerValues = [];

    public function setUp(): void
    {
        $this->eventClass = new Event();
    }

    public function tearDown(): void
    {
        Event::$events = [];
        self::$listenerValues = [];
        parent::tearDown();
    }

    public function test_add_event_to_list()
    {

        $first_event = 'first_event';

        $this->assertCount(0, Event::$events);

        $this->eventClass->registerEvent($first_event);
        $this->assertArrayHasKey($first_event, Event::$events);
        $this->assertCount(1, Event::$events);

        $this->eventClass->registerEvent($first_event);
        $this->assertCount(1, Event::$events);

        $second_event = 'second_event';
        $this->eventClass->registerEvent($second_event);
        $this->assertArrayHasKey($second_event, Event::$events);
        $this->assertCount(2, Event::$events);

        $event = new Event();
        $third_event = 'third_event';
        $this->eventClass->registerEvent($third_event);
        $this->assertCount(3, Event::$events);
    }


    public function test_attach_listener_to_event()
    {
        $event1 = 'event1';
        $event2 = 'event2';

        $this->eventClass->registerEvent($event1);

        $closure = function () {
            echo 'hi';
        };

        $this->eventClass->attach($event1, $closure);

        $this->assertTrue(in_array($closure, Event::$events[$event1]));
        $this->assertInstanceOf(\Closure::class, Event::$events[$event1][0]);

        $object1 = new listenerOne();
        $this->eventClass->attach($event1, $object1);
        $this->assertTrue(in_array($object1, Event::$events[$event1]));
        $this->assertInstanceOf(ListenerInterface::class, Event::$events[$event1][1]);

        $object2 = new listenerOne();
        $this->eventClass->attach($event2, $object2);

        $this->assertTrue(in_array($object2, Event::$events[$event2]));
        $this->assertInstanceOf(ListenerInterface::class, Event::$events[$event2][0]);

        $this->assertCount(2, Event::$events[$event1]);
        $this->assertCount(1, Event::$events[$event2]);

    }

    public function test_invalid_listener_attach_to_event()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('invalid listener type');

        $event = 'event';
        $falseObject = new ListenerNotImplementsListenerInterface();

        $this->eventClass->attach($event, $falseObject);
    }

    public function test_fire_event()
    {
        $event1 = 'event1';
        $event2 = 'event2';

        $this->eventClass->registerEvent($event1);
        $this->eventClass->registerEvent($event2);


        $closure = function () {
            self::$listenerValues['cloture'] = 'hi';
        };

        $closure2 = function () {
            self::$listenerValues['cloture2'] = 'hi2';
        };

        $object = new listenerOne();

        $this->eventClass->attach($event1, $closure);
        $this->eventClass->attach($event1, $object);
        $this->eventClass->attach($event2, $closure2);

        $this->eventClass->fire($event1);

        $this->assertEquals('hi', self::$listenerValues['cloture']);
        $this->assertEquals('something', self::$listenerValues['object']);
        $this->assertFalse(isset(self::$listenerValues['cloture2']));

        $this->eventClass->fire($event2);
        $this->assertEquals('hi2', self::$listenerValues['cloture2']);

    }

    public function test_send_data_to_listener_when_event_fired()
    {
        $event1 = 'event1';

        $this->eventClass->registerEvent($event1);

        $closure = function ($arg1,$arg2) {
            self::$listenerValues['cloture'] = 'hi'.$arg1.$arg2;
        };

        $this->eventClass->attach($event1, $closure);

        $this->eventClass->fire($event1,' test1',' test2');

        $this->assertEquals('hi test1 test2',self::$listenerValues['cloture']);


        $obj = new listenerTwo();

        $this->eventClass->attach($event1, $obj);

        $this->eventClass->fire($event1,' test1',' test2');

        $this->assertEquals('something test1 test2',self::$listenerValues['objectListenerTwo']);

    }

}