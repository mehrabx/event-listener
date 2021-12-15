<?php


namespace Mehrabx\eventListenr\Tests;


class ListenerNotImplementsListenerInterface
{
    public function update()
    {
        echo 'something';
    }
}