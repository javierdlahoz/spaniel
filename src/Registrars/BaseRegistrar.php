<?php

namespace Jdlabs\Spaniel\Registrars;

use HaydenPierce\ClassFinder\ClassFinder;
use Jdlabs\Spaniel\Utils\Config;
use zpt\anno\Annotations;

/**
 * Class BaseRegisterer
 *
 * @package \Jdlabs\Spaniel\Registrars
 */
abstract class BaseRegistrar
{

    abstract public static function scope(): string;

    abstract public static function namespace(): string;

    abstract public static function registerMethodPurpose(
        \ReflectionClass $class,
        \ReflectionMethod $method,
        array $class_annotations,
        array $method_annotations);

    public function register(string $root_namespace)
    {
        foreach (static::getClassesInNamespace($root_namespace) as $controller) {
            static::registerClassPurpose($controller);
        }
    }

    /**
     * @param string $root_namespace
     * @return string[]
     * @throws \Exception
     */
    public static function getClassesInNamespace(string $root_namespace): array
    {
        return ClassFinder::getClassesInNamespace(
            "{$root_namespace}\\" . static::namespace(),
            ClassFinder::RECURSIVE_MODE
        );
    }

    /**
     * @param string $class
     * @param string $purpose
     * @param callable $callback
     * @throws \ReflectionException
     * @throws \zpt\anno\ReflectorNotCommentedException
     */
    public static function registerClassPurpose(string $class): void
    {
        $reflector = new \ReflectionClass($class);
        $class_annotations = (new Annotations($reflector))->asArray();

        if (count($class_annotations) && $class_annotations[static::scope()]) {
            foreach ($reflector->getMethods() as $method) {
                $method_annotations = (new Annotations($method))->asArray();
                static::registerMethodPurpose($reflector, $method, $class_annotations, $method_annotations);
            }
        }
    }

    /**
     * @param \ReflectionClass $class
     * @param \ReflectionMethod $method
     * @return array
     */
    public static function getCallback(\ReflectionClass $class, \ReflectionMethod $method): array
    {
        return [$class->getName()::getInstance(), $method->getName()];
    }

}