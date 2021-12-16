<?php


namespace Mehrabx\eventListenr\Tests;


use Mehrabx\eventListenr\Contracts\ListenerInterface;

class listenerTwo implements ListenerInterface
{

    public function update($data)
    {
        EventTest::$listenerValues['objectListenerTwo'] =  'something'.$data[0].$data[1];
    }
}