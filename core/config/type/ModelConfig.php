<?php

declare(strict_types=1);

namespace Spreng\config\type;

use Spreng\config\type\Config;

class ModelConfig extends Config
{
    public function getTemplateRoot()
    {
        return $this->getOneConfig('templates_root');
    }

    public function setTemplateRoot(string $val)
    {
        $this->setOneConfig('templates_root', $val);
    }

    public function isAutoReloadEnabled(): bool
    {
        return $this->getOneConfig('auto_reload');
    }

    public function disableAutoReload()
    {
        $this->setOneConfig('auto_reload', true);
    }

    public function enableAutoReload()
    {
        $this->setOneConfig('auto_reload', false);
    }
}
