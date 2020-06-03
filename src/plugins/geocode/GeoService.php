<?php

namespace App\plugins\geocode;

use Spreng\connection\DefaultConnPool;

class GeoService
{
    public function __construct($user)
    {
    }

    public function scanRadius(int $needleId, string $haystack, float $radius): array
    {
        $conn = DefaultConnPool::start(); //banco de nome geocode_testes será criado
        $this->user = $conn::findOne($haystack, ' id = ? ', [$needleId]);
        return $conn::getAll("SELECT * ( 6371 * acos( cos( radians(" . $this->user->lat . ") ) * cos( radians(lat) ) * cos( radians(lng) - radians(" . $this->user->lng . ") ) + sin( radians(" . $this->user->lat . ") ) * sin(radians(lat)) ) ) AS distance FROM $haystack HAVING distance < $radius ORDER BY distance");
    }
}
