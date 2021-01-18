<?php

namespace Jdlabs\Spaniel\Registrars;

use Jdlabs\Spaniel\Utils\Config;

class BlockRegistrar implements RegistrarInterface
{

    private function registerBlocksTemplatesPath()
    {
        add_filter('block_lab_template_path', [$this, 'getBlockTemplatesPath']);
    }

    public function getBlockTemplatesPath(): string
    {
        $plugin_config = Config::get('plugin');
        return ABSPATH . 'wp-content/plugins/' . $plugin_config['plugin_dir'] . '/partials';
    }

    public function register(string $root_namespace = null)
    {
        $this->registerBlocksTemplatesPath();

        $blocks = Config::get('blocks');
        foreach ($blocks as $block_key => $block) {
            block_lab_add_block($block_key, $block);
        }
    }
}