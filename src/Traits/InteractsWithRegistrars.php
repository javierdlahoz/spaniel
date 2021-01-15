<?php

namespace Jdlabs\Spaniel\Traits;

use Jdlabs\Spaniel\Registrars\RegistrarInterface;

trait InteractsWithRegistrars
{
    use InteractsWithNamespace;

    protected static $_REGISTRARS_NAMESPACE = 'Jdlabs\\Spaniel\\Registrars\\';

    public function __call($method, $args)
    {
        if (strpos($method, 'register') === 0) {
            $registrar = substr(str_replace('register', '', $method), 0, -1) . 'Registrar';
            $registrar = static::$_REGISTRARS_NAMESPACE . $registrar;

            if (class_exists($registrar)) {
                /** @var RegistrarInterface $registrar_object */
                $registrar_object = new $registrar();
                $registrar_object->register($this->getNamespace());
            }
        }
    }

}