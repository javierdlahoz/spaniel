<?php


namespace Jdlabs\Spaniel\Traits;


use Betsbrothers\Integration\Utils\Config;

trait InteractsWithFilters
{
    public function addFilters()
    {
        $filters = Config::get('filters');
        foreach ($filters as $filter_key => $children_filters) {
            foreach ($children_filters as $filter) {
                $filter_callback = [
                    'Betsbrothers\\Integration\\Filters\\' . $filter['filter'],
                    $filter['method']
                ];

                add_filter($filter_key, $filter_callback);
            }
        }
    }
}