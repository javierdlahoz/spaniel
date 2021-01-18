<?php

namespace Jdlabs\Spaniel\Registrars;

class FilterRegistrar extends BaseRegistrar
{
    const DEFAULT_FILTER_PRIORITY = 10;
    const DEFAULT_ACCEPTED_ARGUMENTS = 1;

    public static function scope(): string
    {
        return 'filter';
    }

    public static function namespace(): string
    {
        return 'Filters';
    }

    public static function registerMethodPurpose(
        \ReflectionClass $class,
        \ReflectionMethod $method,
        array $class_annotations,
        array $method_annotations
    )
    {
        if (isset($method_annotations['hook'])) {
            add_filter(
                $method_annotations['hook'],
                static::getCallback($class, $method),
                $method_annotations['priority'] ?? static::DEFAULT_FILTER_PRIORITY,
                $method_annotations['accepted_args'] ?? static::DEFAULT_ACCEPTED_ARGUMENTS
            );
        }
    }
}