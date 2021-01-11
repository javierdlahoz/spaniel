<?php

namespace Jdlabs\Spaniel\Plugin;


use Jdlabs\Spaniel\Registrars\RouterRegistrar;
use Jdlabs\Spaniel\Traits\InteractsWithBlocks;
use Jdlabs\Spaniel\Traits\InteractsWithFilters;
use Jdlabs\Spaniel\Traits\InteractsWithPages;
use Jdlabs\Spaniel\Traits\InteractsWithPartials;
use Jdlabs\Spaniel\Traits\InteractsWithPluginFiles;
use Jdlabs\Spaniel\Traits\InteractsWithRoles;
use Jdlabs\Spaniel\Traits\InteractsWithShortcodes;

/**
 * Class BasePlugin
 *
 * @package \Jdlabs\Spaniel\Plugin
 */
abstract class BasePlugin
{
    use InteractsWithPartials,
        InteractsWithPages,
        InteractsWithShortcodes,
        InteractsWithFilters,
        InteractsWithRoles,
        InteractsWithBlocks,
        InteractsWithPluginFiles;

    /**
     * @var BasePlugin
     */
    protected static $instance;

    /** @var string  */
    public $name = '';

    /** @var string  */
    public $prefix = '';

    /** @var string  */
    public $version = '';

    /** @var string  */
    public $file = '';

    /**
     * Plugin constructor.
     */
    public function __construct()
    {
        $this->bootstrap();
        add_action('init', [$this, 'registerRoutes']);

        $this->runActions();
        $this->addShortCodes();
        $this->addFilters();
        $this->addPages();

        add_action('block_lab_add_blocks', [$this, 'registerBlocks']);
    }

    /**
     * Bootstrap JS And CSS components
     */
    abstract public function bootstrapComponents();

    /**
     * Bootstrap admin styles and scripts
     */
    abstract public function bootstrapAdmin();

    /**
     * @return string
     */
    protected static function getPluginFileName(): string
    {
        $called_class = new \ReflectionClass((new static()));
        return $called_class->getFileName();
    }

    /**
     * @return string
     */
    public static function assetsDirUrl()
    {
        return plugin_dir_url( static::getPluginFileName() ) . '../assets/';
    }

    /**
     * @return string
     */
    public static function pluginDirUrl()
    {
        return plugin_dir_url( static::getPluginFileName() ) . '../';
    }

    /**
     * @return string
     */
    public static function pluginConfigDir()
    {
        return self::pluginDirBase() . '/../config/';
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
     * @throws \ReflectionException
     * @throws \zpt\anno\ReflectorNotCommentedException
     */
    public function registerRoutes()
    {
        (new RouterRegistrar())->registerRoutes((new \ReflectionClass($this))->getNamespaceName());
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
        add_action(
            'admin_enqueue_scripts',
            [
                __CLASS__,
                'bootstrapAdmin'
            ],
            20,
            1
        );

        add_action(
            'wp_enqueue_scripts',
            [
                __CLASS__,
                'bootstrapComponents'
            ]
        );

        $this->addPlayerRole();
    }

    /**
     * Execute the actions to be added at the beginning
     */
    public function runActions()
    {
//        $actions = Config::get('actions');
//        foreach ($actions as $action_key => $actions_to_resolve) {
//            foreach ($actions_to_resolve as $action) {
//                $action_callback = [
//                    __NAMESPACE__ . '\\Actions\\' . $action['action'],
//                    $action['method']
//                ];
//
//                add_action(
//                    $action_key,
//                    $action_callback,
//                    $action['priority'] ?? 9,
//                    $action['accepted_args'] ?? 1
//                );
//            }
//        }
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