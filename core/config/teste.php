<?php

use Spreng\config\GlobalConfig;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$cc1 = GlobalConfig::getSystemConfig()->getFirstRun();
print_r($cc1);
