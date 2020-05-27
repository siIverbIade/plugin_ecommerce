<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use App\plugins\geocode\Geocode;
use App\plugins\geocode\LocationData;

$ld = new LocationData;

$ld->setPostalCode('23067');
$ld->setCountry('BR');

$gc = new Geocode($ld);
$gr = $gc->getResponse();
print_r($gr->formattedAddress());

//print_r(json_encode($gc->getResponse()));
