<?php


namespace Mehrabx\eventListenr\Contracts;


use Mockery\Matcher\MultiArgumentClosure;
use phpDocumentor\Reflection\Types\Nullable;
use Prophecy\Argument;

interface ListenerInterface
{

    /**
     * this method will call when its event dispatched
     *
     * @param $data
     *
     * @return mixed
     */
    public function update($data);

}