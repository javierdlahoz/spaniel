<?php

/**
 * Plugin Name: Example
 * Plugin URI: http://www.example.com
 * Description: Your blah blah
 * Version: 1.0
 * Author: Jdlabs
 */
if (version_compare(get_bloginfo('version'), '5.2', '<') || version_compare(PHP_VERSION, '7.2', '<')) {
    function spaniel_deactivate_self()
    {
        deactivate_plugins(plugin_basename(__FILE__));
    }

    add_action('admin_init', 'spaniel_deactivate_self');

    return;
} else {
    require_once 'inc/helpers.php';
    require_once 'vendor/autoload.php';

    function jdlabs_get_instance()
    {
        return YourPluginNamespace\Plugin::getInstance(__FILE__);
    }
    jdlabs_get_instance();
}