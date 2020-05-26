<?php

namespace App\plugins\geocode;

use JsonSerializable;

class GeoResponse implements JsonSerializable
{
    public $jsonResponse;

    public function __construct($jsonString)
    {
        $this->jsonResponse = json_decode($jsonString, true);
    }

    public function status()
    {
        return $this->jsonResponse['status'];
    }

    public function results(string $arg = '')
    {
        if ($arg == '') {
            $this->jsonResponse['results'][0];
        } else {
            return $this->jsonResponse['results'][0][$arg];
        }
    }

    public function geolocation(): GeoCoordinates
    {
        return new GeoCoordinates($this->jsonResponse['results'][0]['geometry']['location']);
    }

    public function jsonSerialize()
    {
        return [
            'results' => $this->jsonResponse['results'],
            'status' => $this->jsonResponse['status']
        ];
    }
}
