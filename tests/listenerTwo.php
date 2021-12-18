<?php


namespace Mehrabx\eventListenr\Tests;


use Mehrabx\eventListenr\Contracts\ListenerInterface;

class listenerTwo implements ListenerInterface
{

    public function update($data = null)
    {
        EventTest::$listenerValues['objectListenerTwo'] =  'something'.$data[0].$data[1];
    }
}