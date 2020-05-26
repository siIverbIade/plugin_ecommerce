<?php

declare(strict_types=1);

namespace Spreng\config;

use Spreng\system\files\Json;
use Spreng\config\SessionConfig;
use Spreng\config\type\HttpConfig;
use Spreng\config\type\ModelConfig;
use Spreng\config\type\SystemConfig;
use Spreng\config\type\SecurityConfig;
use Spreng\config\type\ConnectionConfig;

class GlobalConfig
{
    public static function global(): Json
    {
        return new Json(__DIR__ . '/setup.json');
    }

    private static function cfgTypeClass(string $type): string
    {
        return 'Spreng\config\type\\' . ucfirst($type) . 'Config';
    }

    public static function getConfig(string $type): object
    {
        $cfgType = self::cfgTypeClass($type);
        $configObj = new $cfgType;
        $global = self::global();
        $global->process();
        $configObj->asset($global->schemaJSON[$type]);
        return $configObj;
    }

    public static function getConnectionConfig(): ConnectionConfig
    {
        return self::getConfig('connection');
    }

    public static function getHttpConfig(): HttpConfig
    {
        return self::getConfig('http');
    }

    public static function getModelConfig(): ModelConfig
    {
        return self::getConfig('model');
    }

    public static function getSecurityConfig(): SecurityConfig
    {
        return self::getConfig('security');
    }

    public static function getSystemConfig(): SystemConfig
    {
        return self::getConfig('system');
    }

    public static function setConnectionConfig(ConnectionConfig $connectionConfig)
    {
        SessionConfig::setConnectionConfig($connectionConfig);
        self::saveConfig('connection', $connectionConfig->getConfig());
    }

    public static function setHttpConfig(HttpConfig $httpConfig)
    {
        SessionConfig::setHttpConfig($httpConfig);
        self::saveConfig('http', $httpConfig->getConfig());
    }

    public static function setModelConfig(ModelConfig $modelConfig)
    {
        SessionConfig::setModelConfig($modelConfig);
        self::saveConfig('model', $modelConfig->getConfig());
    }

    public static function setSecurityConfig(SecurityConfig $securityConfig)
    {
        SessionConfig::setSecurityConfig($securityConfig);
        self::saveConfig('security', $securityConfig->getConfig());
    }

    public static function setSystemConfig(SystemConfig $systemConfig)
    {
        SessionConfig::setSystemConfig($systemConfig);
        self::saveConfig('system', $systemConfig->getConfig());
    }

    private static function saveConfig(string $type, array $config)
    {
        $global = self::global();
        $global->process();
        $global->schemaJSON[$type] = $config;
        $global->writeSchemaJSON();
    }

    public static function saveAll(array $config)
    {
        $global = self::global();
        $global->process();
        $global->schemaJSON = $config;
        $global->writeSchemaJSON();
    }
}