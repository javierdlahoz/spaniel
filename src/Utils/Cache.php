<?php


namespace Jdlabs\Spaniel\Utils;


class Cache
{

    /**
     * @return array
     */
    public static function config(): array
    {
        return Config::get('plugin')['cache'];
    }

    /**
     * @return string
     */
    public static function group(): string
    {
        return self::config()['group'];
    }

    /**
     * @param string $key
     * @return false|mixed
     */
    public static function get(string $key)
    {
        return wp_cache_get($key, self::group());
    }

    /**
     * @param string $key
     * @param $data
     * @param int $expire
     */
    public static function set(string $key, $data, int $expire)
    {
        wp_cache_set($key, $data, self::group(), $expire);
    }

    /**
     * Flush the cached data
     */
    public static function flush()
    {
        wp_cache_flush();
    }

    /**
     * @param string $key
     * @param callable $callable
     * @param int|null $expire
     * @return mixed
     */
    public static function remember(string $key, callable $callable, ?int $expire = null)
    {
        $response = self::get($key);

        if (!$response) {
            // Only stores value in cache if is not null
            if ($response = $callable()) {
                self::set($key, $response, $expire ?? self::config()['ttl']);
            }
        }

        return $response;
    }
}