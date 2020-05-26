<?php

namespace Spreng\config\type;

abstract class Config
{
    protected array $config;

    public function asset(array $config)
    {
        $this->config = $config;
    }

    public function getOneConfig(string $arg)
    {
        return $this->config[$arg];
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setOneConfig(string $arg, $val)
    {
        return $this->config[$arg] = $val;
    }

    public function setConfig($val)
    {
        $this->config = $val;
    }

    public function mergeConfig(array $val)
    {
        $this->config = array_merge(isset($this->config) ? $this->config : [], $val);
    }
}
