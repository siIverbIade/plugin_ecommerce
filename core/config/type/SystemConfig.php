<?php

declare(strict_types=1);

namespace Spreng\config\type;

use Spreng\config\type\Config;

class SystemConfig extends Config
{
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getSourcePath(): string
    {
        return $this->getOneConfig('autoloader')['source_path'];
    }

    public function getSourceClass(): string
    {
        return $this->getOneConfig('autoloader')['source_class'];
    }

    public function getFirstRun(): bool
    {
        return $this->getOneConfig('first_run');
    }

    public function setSourcePath(string $val)
    {
        $this->config['autoloader']['source_path'] = $val;
    }

    public function setSourceClass(string $val)
    {
        $this->config['autoloader']['source_class'] = $val;
    }

    public function setFirstRun(bool $val)
    {
        $this->setOneConfig('first_run', $val);
    }
}
