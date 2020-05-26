<?php

declare(strict_types=1);

namespace Spreng\config;

use Spreng\config\GlobalConfig;
use Spreng\config\type\HttpConfig;
use Spreng\config\type\ModelConfig;
use Spreng\config\type\SystemConfig;
use Spreng\config\type\SecurityConfig;
use Spreng\system\Loader\SprengClasses;
use Spreng\config\type\ConnectionConfig;

class SessionConfig
{
    public static function getConnectionConfig(): ConnectionConfig
    {
        if (isset($_SESSION['config']['connection'])) {
            $config = new ConnectionConfig();
            $config->asset($_SESSION['config']['connection']);
        } else {
            $config = GlobalConfig::getConnectionConfig();
            $_SESSION['config']['connection'] = $config->getConfig();
        }
        return $config;
    }

    public static function getHttpConfig(): HttpConfig
    {
        if (isset($_SESSION['config']['http'])) {
            $config = new HttpConfig();
            $config->asset($_SESSION['config']['http']);
        } else {
            $config = GlobalConfig::getHttpConfig();
            $_SESSION['config']['http'] = $config->getConfig();
        }
        return $config;
    }

    public static function getModelConfig(): ModelConfig
    {
        if (isset($_SESSION['config']['model'])) {
            $config = new ModelConfig();
            $config->asset($_SESSION['config']['model']);
        } else {
            $config = GlobalConfig::getModelConfig();
            $_SESSION['config']['model'] = $config->getConfig();
        }
        return $config;
    }

    public static function getSecurityConfig(): SecurityConfig
    {
        if (isset($_SESSION['config']['security'])) {
            $config = new SecurityConfig();
            $config->asset($_SESSION['config']['security']);
        } else {
            $config = GlobalConfig::getSecurityConfig();
            $_SESSION['config']['security'] = $config->getConfig();
        }
        return $config;
    }

    public static function getSystemConfig(): SystemConfig
    {
        if (isset($_SESSION['config']['system'])) {
            $config = new SystemConfig();
            $config->asset($_SESSION['config']['system']);
        } else {
            $config = GlobalConfig::getSystemConfig();
            $_SESSION['config']['system'] = $config->getConfig();
        }
        return $config;
    }

    public static function getAllImplementationsOf(string $class): array
    {
        if (isset($_SESSION['config']['classes'])) {
            return $_SESSION['config']['classes'];
        } else {
            $_SESSION['config']['classes'] = SprengClasses::scanFromSource($class);
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
