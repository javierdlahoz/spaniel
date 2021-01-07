<?php

namespace Jdlabs\Spaniel\Filters;


abstract class BaseFilter
{

    /**
     * @param array $query_vars
     * @param array $arguments
     * @return array[]
     */
    public function attachToQueryVars(array $query_vars, array $arguments): array
    {
        $query_vars = [...$query_vars, ...$arguments];
        return $query_vars;
    }
}