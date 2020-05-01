<?php
/*
Plugin Name: NormandieMKT - WMS
Plugin URI: http://normandiemkt.fr
Description: WMS PLugin
Author: NormandieMKT
Version: 1.0
*/

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('logs/info.log', Logger::WARNING));

// add records to the log
$log->warning('Foo');
$log->error('Bar');
