<?php

declare(strict_types=1);

namespace Spreng\connection;

use Spreng\connection\Connection;

class DefaultConnPool extends Connection
{
    public function __construct()
    {
        parent::__construct('system');
    }
}
