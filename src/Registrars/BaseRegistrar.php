<?php

namespace Jdlabs\Spaniel\Registrars;

use HaydenPierce\ClassFinder\ClassFinder;
use zpt\anno\Annotations;

/**
 * Class BaseRegisterer
 *
 * @package \Jdlabs\Spaniel\Registrars
 */
abstract class BaseRegistrar
{

    /**
     * @param string $root_namespace
     * @param string $namespace
     * @return string[]
     * @throws \Exception
     */
    public function getClassesInNamespace(string $root_namespace, string $namespace): array
    {
        return ClassFinder::getClassesInNamespace(
            "{$root_namespace}\{$namespace}",
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
    public static function registerClassPurpose(string $class, string $purpose, callable $callback): void
    {
        $reflector = new \ReflectionClass($class);
        $class_annotations = (new Annotations($reflector))->asArray();

        if (count($class_annotations) && $class_annotations[$purpose]) {
            foreach ($reflector->getMethods() as $method) {
                $method_annotations = (new Annotations($method))->asArray();
                $callback($reflector, $method_annotations);

//                if (count($method_annotations) && $method_annotations['route']) {
//                    static::registerMethodRoute(
//                        $reflector->getName(),
//                        $method->getName(),
//                        $class_annotations,
//                        $method_annotations
//                    );
//                }
            }
        }
    }

}