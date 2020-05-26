<?php

namespace App\plugins\geocode;

use Spreng\connection\DefaultConnPool;

class GeoService
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function scanRadius(float $radius): array
    {
        $conn = DefaultConnPool::start(); //banco de nome geocode_testes será criado
        $this->user = $conn::findOne('clientes', ' id = ? ', [$this->id]);
        return $conn::getAll("SELECT id, name, ( 3959 * acos( cos( radians($this->user->lat) ) * cos( radians(lat) ) * cos( radians(lng) - radians($this->user->lng) ) + sin( radians($this->user->lat) ) * sin(radians(lat)) ) ) AS distance FROM clientes HAVING distance < $radius ORDER BY distance");
    }
}
