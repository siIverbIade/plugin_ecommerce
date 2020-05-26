<?php

namespace Spreng\connection;

use PDO;
use PDOException;

class Database
{
    public static function new($url, $db, $user, $password)
    {
        try {
            $dbh = new PDO("mysql:host=$url", $user, $password);

            $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db`;
                CREATE USER IF NOT EXISTS'$user'@'$url' IDENTIFIED BY '$password';
                GRANT ALL ON `$db`.* TO '$user'@'$url';
                FLUSH PRIVILEGES;");
        } catch (PDOException $e) {
        }
    }
}
