<?php


namespace Mehrabx\eventListenr\Tests;


class ListenerNotImplementsListenerInterface
{
    public function update()
    {
        EventTest::$listenerValues['object'] =  'something';
    }
}