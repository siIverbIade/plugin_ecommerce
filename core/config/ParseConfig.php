<?php

declare(strict_types=1);

namespace Spreng\config;

use Spreng\system\files\Json;
use Spreng\config\type\Config;
use Spreng\config\type\HttpConfig;
use Spreng\config\type\ModelConfig;
use Spreng\config\type\SystemConfig;
use Spreng\config\type\SecurityConfig;
use Spreng\config\type\ConnectionConfig;

class ParseConfig
{
    private static function global(): Json
    {
        return new Json(__DIR__ . '/resources/setup.json');
    }

    private static function cfgTypeClass(string $type): string
    {
        return 'Spreng\config\type\\' . ucfirst($type) . 'Config';
    }

    protected static function loadConfig(string $type): Config
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
        return self::loadConfig('connection');
    }

    public static function getHttpConfig(): HttpConfig
    {
        return self::loadConfig('http');
    }

    public static function getModelConfig(): ModelConfig
    {
        return self::loadConfig('model');
    }

    public static function getSecurityConfig(): SecurityConfig
    {
        return self::loadConfig('security');
    }

    public static function getSystemConfig(): SystemConfig
    {
        return self::loadConfig('system');
    }

    public static function setConnectionConfig(ConnectionConfig $connectionConfig)
    {
        self::saveConfig('connection', $connectionConfig->getConfig());
    }

    public static function setHttpConfig(HttpConfig $httpConfig)
    {
        self::saveConfig('http', $httpConfig->getConfig());
    }

    public static function setModelConfig(ModelConfig $modelConfig)
    {
        self::saveConfig('model', $modelConfig->getConfig());
    }

    public static function setSecurityConfig(SecurityConfig $securityConfig)
    {
        self::saveConfig('security', $securityConfig->getConfig());
    }

    public static function setSystemConfig(SystemConfig $systemConfig)
    {
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
