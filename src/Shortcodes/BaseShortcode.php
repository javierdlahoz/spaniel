<?php

namespace Jdlabs\Spaniel\Shortcodes;

use Jdlabs\Spaniel\Utils\Singleton;

abstract class BaseShortcode extends Singleton
{
    /**
     * @param $attrs
     * @return array
     */
    public static function sanitizeAttributes($attrs): array
    {
        return (!is_array($attrs)) ? (array) $attrs : $attrs;
    }

    /**
     * @param string $tag
     * @param array $args
     */
    public static function doShortCode(string $tag, array $args = []): void
    {
        try {
            $string_args = '';
            foreach ($args as $key => $value) {
                if (!empty($value) || $value === false) {
                    $value = is_bool($value) ? (int) $value : $value;
                    $string_args .= " {$key}='{$value}'";
                }
            }

            echo do_shortcode("[{$tag} {$string_args}]");
        } catch (\Exception $ex) {
            // TODO: nothing here
        }
    }
}