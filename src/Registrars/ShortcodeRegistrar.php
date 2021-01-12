<?php

namespace Jdlabs\Spaniel\Registrars;

class ShortcodeRegistrar extends BaseRegistrar
{

    public static function scope(): string
    {
        return 'shortcode';
    }

    public static function namespace(): string
    {
        return 'Shortcodes';
    }

    public static function registerMethodPurpose(
        \ReflectionClass $class,
        \ReflectionMethod $method,
        array $class_annotations,
        array $method_annotations
    )
    {
        if ($method_annotations['tag']) {
            add_shortcode(
                $method_annotations['tag'],
                static::getCallback($class, $method)
            );
        }
    }
}