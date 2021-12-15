<?php


namespace Mehrabx\eventListenr\Tests;


use Mehrabx\eventListenr\Contracts\ListenerInterface;

class listenerOne implements ListenerInterface
{

    public function update($data)
    {
        echo 'listener1';
    }
}