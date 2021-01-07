<?php

namespace Jdlabs\Spaniel\Shortcodes;

/**
 * Class BaseShortcode
 *
 * @package \Jdlabs\Spaniel\Shortcodes
 */
abstract class BaseShortcode
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
     * @param string $code
     * @param array $args
     */
    public static function doShortCode(string $code, array $args = []): void
    {
        try {
            $string_args = '';
            foreach ($args as $key => $value) {
                if (!empty($value) || $value === false) {
                    $value = is_bool($value) ? (int) $value : $value;
                    $string_args .= " {$key}='{$value}'";
                }
            }

            echo do_shortcode("[{$code} {$string_args}]");
        } catch (\Exception $ex) {
            // TODO: nothing here
        }
    }
}