<?php

namespace Dikki\Clipro\Core\Config;

use Dikki\Config\ConfigFetcher;
use Dikki\Clipro\Core\Clipro;

class Config
{
    private ConfigFetcher $configFetcher;

    public function __construct()
    {
        $configDir = Clipro::getConfigDir();
        $this->configFetcher = new ConfigFetcher($configDir);
    }

    public function getAll(): mixed
    {
        return $this->configFetcher->fetchAllConfigs();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->configFetcher->get(key: $key, default: $default);
    }
}
