<?php

declare(strict_types=1);

namespace Spreng\config\type;

use Spreng\config\type\Config;

class SystemConfig extends Config
{
    public function getSourcePath(): string
    {
        return $this->getOneConfig('autoloader')['source_path'];
    }

    public function setSourcePath(string $val)
    {
        $this->config['autoloader']['source_path'] = $val;
    }

    public function getSourceClass(): string
    {
        return $this->getOneConfig('autoloader')['source_class'];
    }

    public function setSourceClass(string $val)
    {
        $this->config['autoloader']['source_class'] = $val;
    }
}
