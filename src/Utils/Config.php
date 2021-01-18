<?php


namespace Jdlabs\Spaniel\Utils;


use Jdlabs\Spaniel\Traits\InteractsWithPluginFiles;

class Config
{
    use InteractsWithPluginFiles;

    /**
     * @param string $filename
     * @return mixed
     */
    protected static function getConfigFileParams(string $filename): array
    {
        $file_path = self::pluginConfigDir() . $filename . '.php';
        if (!file_exists($file_path)) {
            return [];
        }

        return include $file_path;
    }

    /**
     * @param string $config
     * @param null $default
     * @return array|mixed|null
     */
    public static function get(string $config, $default = null)
    {
        $paths = explode('.', $config);
        $filename = array_shift($paths);

        $file_configs = self::getConfigFileParams($filename);
        foreach ($paths as $path) {
            if (!$file_configs[$path]) {
                return $default;
            }

            $file_configs = $file_configs[$path];
        }

        return $file_configs;
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