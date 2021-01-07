<?php

namespace Jdlabs\Spaniel\Traits;

trait InteractsWithPluginFiles
{

    /**
     * @return string
     */
    public static function pluginDirBase(): string
    {
        // TODO: Find a better way to achieve this
        return __DIR__ . '../../../';
    }
}