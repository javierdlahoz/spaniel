<?php

namespace Jdlabs\Spaniel\Registrars;


use Jdlabs\Spaniel\Utils\Config;
use zpt\anno\Annotations;

class RouterRegistrar extends BaseRegistrar
{
    /**
     * @param string $root_namespace
     * @throws \ReflectionException
     * @throws \zpt\anno\ReflectorNotCommentedException
     * @throws \Exception
     */
    public function registerRoutes(string $root_namespace): void
    {
        foreach ($this->getClassesInNamespace($root_namespace, 'Controllers') as $controller) {
            static::registerControllerRoutes($controller);
        }

        $routes = Config::get('routes/web');
        foreach ($routes as $route_key => $route) {
            add_rewrite_rule(
                $route_key,
                $route['target'],
                $route['priority'] ?? 'top'
            );

            foreach ($route['tags'] ?? [] as $tag) {
                add_rewrite_tag("%{$tag}%", '([^&]+)');
            }
        }

        flush_rewrite_rules();
    }

    /**
     * @param string $class
     * @throws \ReflectionException
     * @throws \zpt\anno\ReflectorNotCommentedException
     */
    public static function registerControllerRoutes(string $class): void
    {
        $reflector = new \ReflectionClass($class);
        $controller_annotations = (new Annotations($reflector))->asArray();

        if (count($controller_annotations) && $controller_annotations['route']) {
            foreach ($reflector->getMethods() as $method) {
                $method_annotations = (new Annotations($method))->asArray();

                if (count($method_annotations) && $method_annotations['route']) {
                    static::registerMethodRoute(
                        $reflector->getName(),
                        $method->getName(),
                        $controller_annotations,
                        $method_annotations
                    );
                }
            }
        }
    }

    /**
     * @param string $controller
     * @param string $method
     * @param array $controller_annotations
     * @param array $method_annotations
     */
    public static function registerMethodRoute(
        string $controller,
        string $method,
        array $controller_annotations,
        array $method_annotations
    ): void
    {
        if ($controller_annotations['route']) {

            $route_callback = [
                'methods' => $method_annotations['method'] ?? 'GET',
                'callback' => [$controller::getInstance(), $method]
            ];

            register_rest_route(
                Config::get('plugin')['routes_prefix'],
                "{$controller_annotations['route']}/{$method_annotations['route']}",
                $route_callback
            );
        }
    }
}
}