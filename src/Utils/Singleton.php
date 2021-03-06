<?php

namespace Jdlabs\Spaniel\Utils;


class Singleton
{
    /**
     * @return Singleton
     */
    public static function getInstance()
    {
        static $instances = array();
        $called_class = get_called_class();

        if (!isset($instances[$called_class])) {
            $instances[$called_class] = new $called_class();
        }

        return $instances[$called_class];
    }
}