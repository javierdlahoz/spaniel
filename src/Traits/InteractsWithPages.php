<?php

namespace Jdlabs\Spaniel\Traits;

use Jdlabs\Spaniel\Utils\Config;

trait InteractsWithPages
{
    public function addPages()
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