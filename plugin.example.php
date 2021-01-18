<?php

if (version_compare(get_bloginfo('version'), '5.2', '<') || version_compare(PHP_VERSION, '7.2', '<')) {
    function spaniel_compatability_warning()
    {
        echo '<div class="error"><p>' . sprintf(
                __('“%1$s” requires PHP %2$s (or newer) and WordPress %3$s (or newer) to function properly. Your site is using PHP %4$s and WordPress %5$s. Please upgrade. The plugin has been automatically deactivated.', 'TEXT_DOMAIN'),
                __('PLUGIN_NAME', 'TEXT_DOMAIN'),
                '7.2',
                '5.2',
                PHP_VERSION,
                $GLOBALS['wp_version']
            ) . '</p></div>';
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
    }
    add_action('admin_notices', 'spaniel_compatability_warning');

    function spaniel_deactivate_self()
    {
        deactivate_plugins(plugin_basename(__FILE__));
    }
    add_action('admin_init', 'spaniel_deactivate_self');

    return;
} else {
    require_once __DIR__ . '/vendor/autoload.php';

    function spaniel_get_instance()
    {
        return YOURNAMESPACE\Plugin::getInstance(__FILE__);
    }

    spaniel_get_instance();
}