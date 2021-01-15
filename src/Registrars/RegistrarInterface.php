<?php

namespace Jdlabs\Spaniel\Registrars;

interface RegistrarInterface
{
    public function register(string $root_namespace = null);
}