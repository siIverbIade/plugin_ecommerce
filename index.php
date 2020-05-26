<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use App\plugins\geocode\Geocode;
use App\plugins\geocode\LocationData;

$ld = new LocationData;
$ld->setAddress('cep 23067-100');
$ld->setLocation('BR');
$gc = new Geocode($ld);
$gr = $gc->getResponse();
print_r($gr->geolocation()->getLatitud());
//print_r($gc->getResponse()->jsonSerialize());
