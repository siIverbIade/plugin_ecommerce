<?php

declare(strict_types=1);

namespace Spreng\connection;

use Spreng\connection\Database;
use Spreng\config\SessionConfig;
use Spreng\connection\Connection;

class DefaultConnPool
{
    public static function start(): Connection
    {
        $param = SessionConfig::getConnectionConfig();
        $regenerate = $param->getRegenerate('system');
        $conn = new Connection($param->getUrl('system') . ":" . $param->getPort('system'), $param->getDatabase('system'), $param->getUser('system'), $param->getPassword('system'), !$regenerate);

        if ($regenerate) {
            Database::new($param->getUrl('system') . ":" . $param->getPort('system'), $param->getDatabase('system'), $param->getUser('system'), $param->getPassword('system'));
            $conn->conectaDB();
        }

        return $conn;
    }
}
