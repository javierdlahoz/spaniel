<?php

namespace Jdlabs\Spaniel\Registrars;

use Jdlabs\Spaniel\Utils\Config;

class BlockRegistrar implements RegistrarInterface
{

    public function register(string $root_namespace = null)
    {
        $blocks = Config::get('blocks');
        foreach ($blocks as $block_key => $block) {
            block_lab_add_block($block_key, $block);
        }
    }
}