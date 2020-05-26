<?php

use Spreng\config\GlobalConfig;

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

$gs = new GlobalConfig();
$connConfig = $gs::getConnectionConfig();

$connConfig->setUrl('system', $_GET['url']);
$connConfig->setPort('system', $_GET['porta']);
$connConfig->setDatabase('system', $_GET['nomedb']);
$connConfig->setUser('system', $_GET['usuario']);
$connConfig->setPassword('system', $_GET['senha']);

$gs->setConnectionConfig($connConfig);
