<?php

namespace Jdlabs\Spaniel\Registrars;


class ActionRegistrar extends BaseRegistrar
{
    const DEFAULT_ACTION_PRIORITY = 10;
    const DEFAULT_ACCEPTED_ARGUMENTS = 1;

    public static function scope(): string
    {
        return 'action';
    }

    public static function namespace(): string
    {
        return 'Actions';
    }

    public static function registerMethodPurpose(
        \ReflectionClass $class,
        \ReflectionMethod $method,
        array $class_annotations,
        array $method_annotations
    )
    {
        if (isset($method_annotations['hook'])) {
            add_action(
                $method_annotations['hook'],
                static::getCallback($class, $method),
                $method_annotations['priority'] ?? static::DEFAULT_ACTION_PRIORITY,
                $method_annotations['accepted_args'] ?? static::DEFAULT_ACCEPTED_ARGUMENTS
            );
        }
    }
}