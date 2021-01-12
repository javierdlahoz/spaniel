<?php

namespace Jdlabs\Spaniel\Traits;

trait InteractsWithNamespace
{

    public function getNamespace()
    {
        return (new \ReflectionClass($this))->getNamespaceName();
    }
}