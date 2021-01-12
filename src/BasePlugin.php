<?php

namespace Jdlabs\Spaniel;

use Jdlabs\Spaniel\Traits\InteractsWithBlocks;
use Jdlabs\Spaniel\Traits\InteractsWithFilters;
use Jdlabs\Spaniel\Traits\InteractsWithPages;
use Jdlabs\Spaniel\Traits\InteractsWithPartials;
use Jdlabs\Spaniel\Traits\InteractsWithPluginFiles;
use Jdlabs\Spaniel\Traits\InteractsWithRoles;
use Jdlabs\Spaniel\Traits\InteractsWithShortcodes;
use Jdlabs\Spaniel\Traits\InteractsWithRegistrars;

abstract class BasePlugin
{
    use InteractsWithPartials,
        InteractsWithPages,
        InteractsWithBlocks,
        InteractsWithPluginFiles,
        InteractsWithRegistrars;

    /** @var BasePlugin */
    protected static $instance;

    /** @var string  */
    public string $name = '';

    /** @var string  */
    public string $prefix = '';

    /** @var string  */
    public string $version = '';

    /** @var string  */
    public string $file = '';

    /**
     * Bootstrap JS And CSS components
     */
    abstract public function bootstrapComponents();

    /**
     * Bootstrap admin styles and scripts
     */
    abstract public function bootstrapAdmin();

    /**
     * Plugin constructor.
     */
    public function __construct()
    {
        $this->bootstrap();
        add_action('init', [$this, 'registerRoutes']);
        add_action('init', [$this, 'registerFilters']);
        add_action('init', [$this, 'registerActions']);
        add_action('init', [$this, 'registerShortcodes']);

        $this->addPages();

        add_action('block_lab_add_blocks', [$this, 'registerBlocks']);
    }

    /**
     * Creates an instance if one isn't already available,
     * then return the current instance.
     *
     * @param  string $file The file from which the class is being instantiated.
     * @return object       The class instance.
     */
    public static function getInstance($file)
    {
        if (!isset(self::$instance) && !(self::$instance instanceof self)) {
            self::$instance = new static();

            if (! function_exists('get_plugin_data')) {
                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            }

            $data = get_plugin_data($file);

            self::$instance->name = $data['Name'];
            self::$instance->prefix = $data['Prefix'] ?? 'spaniel';
            self::$instance->version = $data['Version'];
            self::$instance->file = $file;

            self::$instance->run();
        }
        return self::$instance;
    }

    /**
     * Execution function which is called after the class has been initialized.
     * This contains hook and filter assignments, etc.
     */
    private function run()
    {
        add_action('plugins_loaded', array($this, 'loadPluginTextdomain'));
    }

    /**
     * Load translation files from the indicated directory.
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain('TEXT_DOMAIN', false, dirname(plugin_basename($this->file)) . '/languages');
    }

    /**
     * bootstrap the plugin
     */
    public function bootstrap()
    {
        add_action('admin_enqueue_scripts', [__CLASS__, 'bootstrapAdmin'], 20, 1);
        add_action('wp_enqueue_scripts', [__CLASS__, 'bootstrapComponents']);
    }

    /**
     * Register edition blocks
     */
    public function registerBlocks()
    {
        $blocks = Config::get('blocks');
        foreach ($blocks as $block_key => $block) {
            $this->registerBlock($block_key, $block);
        }
    }
}