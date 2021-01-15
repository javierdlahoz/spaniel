<?php

namespace Jdlabs\Spaniel\Registrars;

use Jdlabs\Spaniel\Utils\Config;

class PageRegistrar implements RegistrarInterface
{
    public function register(string $root_namespace = null)
    {
        $pages = Config::get('pages');
        foreach ($pages as $page) {
            $obj_page = get_page_by_title($page['post_title'], 'OBJECT', $page['post_type'] ?? 'page');
            if (empty($obj_page)) {
                wp_insert_post($page);
            }
        }
    }
}