<?php

declare(strict_types=1);

namespace Spreng\config\type;

use Spreng\config\type\Config;

class HttpConfig extends Config
{
    public function getListenPort(): string
    {
        return $this->getOneConfig('listen_port');
    }

    public function setListenPort(string $val)
    {
        return $this->setOneConfig('listen_port', $val);
    }
}
