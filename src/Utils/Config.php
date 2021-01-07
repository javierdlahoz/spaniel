<?php


namespace Jdlabs\Spaniel\Utils;


use Jdlabs\Spaniel\Traits\InteractsWithPluginFiles;

class Config
{
    use InteractsWithPluginFiles;

    /**
     * @param string $filename
     * @return array
     */
    public static function get(string $filename): array
    {
        return include self::pluginConfigDir() . $filename . '.php';
    }

    /**
     * @return string|null
     */
    public static function configPrefix(): ?string
    {
        return self::get('plugin')['config_prefix'];
    }

    /**
     * @param string $option
     * @return bool|mixed|void
     */
    public static function getOption(string $option)
    {
        return get_option(self::configPrefix() . $option);
    }
}