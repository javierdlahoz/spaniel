<?php

namespace Jdlabs\Spaniel\Traits;

use Jdlabs\Spaniel\Registrars\ActionRegistrar;
use Jdlabs\Spaniel\Registrars\FilterRegistrar;
use Jdlabs\Spaniel\Registrars\RouterRegistrar;
use Jdlabs\Spaniel\Registrars\ShortcodeRegistrar;

trait InteractsWithRegistrars
{
    use InteractsWithNamespace;

    public function registerRoutes()
    {
        (new RouterRegistrar())->register($this->getNamespace());
    }

    public function registerFilters()
    {
        (new FilterRegistrar())->register($this->getNamespace());
    }

    public function registerActions()
    {
        (new ActionRegistrar())->register($this->getNamespace());
    }

    public function registerShortcodes()
    {
        (new ShortcodeRegistrar())->register($this->getNamespace());
    }
}