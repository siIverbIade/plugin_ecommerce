<?php

use Spreng\config\GlobalConfig;
use Spreng\config\SessionConfig;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$cc1 = SessionConfig::getSystemConfig()->getProjectPath();
print_r($cc1);
