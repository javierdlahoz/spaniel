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
        return __DIR__ . '../../../../../';
    }

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
        return self::pluginDirBase() . '../config/';
    }
}