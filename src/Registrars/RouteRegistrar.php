<?php

namespace Jdlabs\Spaniel\Registrars;


use Jdlabs\Spaniel\Utils\Config;

class RouteRegistrar extends BaseRegistrar
{

    public static function scope(): string
    {
        return 'route';
    }

    public static function namespace(): string
    {
        return 'Controllers';
    }

    public function register(?string $root_namespace = null): void
    {
        parent::register($root_namespace);

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

    public static function registerMethodPurpose(
        \ReflectionClass $class,
        \ReflectionMethod $method,
        array $class_annotations,
        array $method_annotations
    )
    {
        if (count($method_annotations) && $method_annotations['route']) {
            static::registerMethodRoute(
                $class->getName(),
                $method->getName(),
                $class_annotations,
                $method_annotations
            );
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
    )
    {
        if ($controller_annotations[static::scope()]) {
            $route_callback = [
                'methods' => $method_annotations['method'] ?? 'GET',
                'callback' => [$controller::getInstance(), $method]
            ];

            register_rest_route(
                Config::get('plugin.routes_prefix'),
                "{$controller_annotations['route']}/{$method_annotations['route']}",
                $route_callback
            );
        }
    }
}