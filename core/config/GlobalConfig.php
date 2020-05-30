<?php

declare(strict_types=1);

namespace Spreng\config;

use Spreng\config\ParseConfig;
use Spreng\config\type\HttpConfig;
use Spreng\config\type\ModelConfig;
use Spreng\config\type\SystemConfig;
use Spreng\config\type\SecurityConfig;
use Spreng\system\Loader\SprengClasses;
use Spreng\config\type\ConnectionConfig;

class GlobalConfig
{
    public static function getConfig(string $type): array
    {
        $config = [];
        if (isset($_SESSION['config'][$type])) {
            $config = $_SESSION['config'][$type];
        } else {
            $config = ParseConfig::getConfig($type)->getConfig();
            $_SESSION['config'][$type] = $config;
        }
        return $config;
    }

    public static function getConnectionConfig(): ConnectionConfig
    {
        return new ConnectionConfig(self::getConfig('connection'));
    }

    public static function getHttpConfig(): HttpConfig
    {
        return new HttpConfig(self::getConfig('http'));
    }

    public static function getModelConfig(): ModelConfig
    {
        return new ModelConfig(self::getConfig('model'));
    }

    public static function getSecurityConfig(): SecurityConfig
    {
        return new SecurityConfig(self::getConfig('security'));
    }

    public static function getSystemConfig(): SystemConfig
    {
        return new SystemConfig(self::getConfig('system'));
    }

    public static function getAllImplementationsOf(string $baseFolder, string $class): array
    {
        if (isset($_SESSION['config']['classes'])) {
            return $_SESSION['config']['classes'];
        } else {
            $_SESSION['config']['classes'] = SprengClasses::scanFromSource($baseFolder, $class);
        }
        return $_SESSION['config']['classes'];
    }

    public static function setConnectionConfig(ConnectionConfig $config)
    {
        $_SESSION['config']['connection'] = $config->getConfig();
    }

    public static function setHttpConfig(HttpConfig $config)
    {
        $_SESSION['config']['http'] = $config->getConfig();
    }

    public static function setModelConfig(ModelConfig $config)
    {
        $_SESSION['config']['model'] = $config->getConfig();
    }

    public static function setSecurityConfig(SecurityConfig $config)
    {
        $_SESSION['config']['security'] = $config->getConfig();
    }

    public static function setSystemConfig(SystemConfig $config)
    {
        $_SESSION['config']['system'] = $config->getConfig();
    }

    public static function clearAll()
    {
        if (isset($_SESSION['config'])) unset($_SESSION['config']);
    }
}
