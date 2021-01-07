<?php

namespace Jdlabs\Spaniel\Traits;


use Betsbrothers\Integration\Plugin;

trait InteractsWithPartials
{
    /**
     * @param string $path
     * @return string
     */
    public static function getPartialPath(string $path): string
    {
        return Plugin::pluginDirBase() . '/../partials/' . $path . '.php';
    }

    /**
     * @param string $path
     */
    public static function includePartial(string $path): void
    {
        include self::getPartialPath($path);
    }

    /**
     * @param string $path
     * @param array $variables
     * @return string
     */
    public static function renderPartial(string $path, array $variables = []): string
    {
        extract($variables, EXTR_OVERWRITE);
        ob_start();
        include self::getPartialPath($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}