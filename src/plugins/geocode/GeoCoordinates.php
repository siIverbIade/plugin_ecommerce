<?php

namespace App\plugins\geocode;

class GeoCoordinates
{
    protected float $lat;
    protected float $lng;

    public function __construct(array $location)
    {
        $this->lat = $location['lat'];
        $this->lng = $location['lng'];
    }
    public function getLatitud(): float
    {
        return $this->lat;
    }

    public function getLongitud(): float
    {
        return $this->lng;
    }
}
