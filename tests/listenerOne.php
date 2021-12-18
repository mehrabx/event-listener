<?php


namespace Mehrabx\eventListenr\Tests;


use Mehrabx\eventListenr\Contracts\ListenerInterface;

class listenerOne implements ListenerInterface
{

    public function update($data = null)
    {
        EventTest::$listenerValues['object'] =  'something';
    }
}