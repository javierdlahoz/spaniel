<?php


namespace Jdlabs\Spaniel\Traits;


use Betsbrothers\Integration\Utils\Config;

trait InteractsWithShortcodes
{
    public function addShortCodes()
    {
        $shortcodes = Config::get('shortcodes');
        foreach ($shortcodes as $shortcode_key => $shortcode) {
            $shortcode_callback = [
                'Betsbrothers\\Integration\\Shortcodes\\' . $shortcode['handler'],
                $shortcode['method']
            ];

            add_shortcode($shortcode_key, $shortcode_callback);
        }
    }
}