<?php

declare(strict_types=1);

use Dikki\Clipro\Core\Config\Config;

if (!function_exists('config')) {
    /**
     * Get config value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        static $config = null;

        if ($config === null) {
            $config = new Config();
        }

        return $config->get($key, $default);
    }
}
/**
 * Get language translation
 *
 * @param string $text
 * @param string $lang
 * @return mixed
 */
function lang(string $text, string $lang): mixed
{
    return config('lang.text.' . $lang)[strtolower($text)] ?? $text;
}
