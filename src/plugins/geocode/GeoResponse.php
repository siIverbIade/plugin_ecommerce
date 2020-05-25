<?php

namespace App\plugins\geocode;

use JsonSerializable;

class GeoResponse implements JsonSerializable
{
    private array $jsonResponse;

    public function __construct(string $jsonString)
    {
        $this->jsonResponse = json_decode($jsonString);
    }

    public function jsonSerialize()
    {
        return [
            'response' => [
                'address' => $this->jsonResponse['address'],
                'country' => $this->jsonResponse['country']
            ]
        ];
    }
}
