<?php

namespace App\plugins\geocode;

use App\plugins\geocode\GeoResponse;
use App\plugins\geocode\LocationData;

class Geocode
{
  private LocationData $locationData;
  private $resource;

  public function __construct(LocationData $locationData)
  {
    $this->locationData = $locationData;
    $this->resource = curl_init();
  }

  public function getResponse(string $chave = 'AIzaSyAgjxGGak84swcADckEZIOUEyhBpZPP1Mg')
  {
    //if (!isset($this->resource)) {
    $params = $this->locationData->getParameters();
    $options = [
      CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?$params" . "key=$chave",
      CURLOPT_RETURNTRANSFER => true,
    ];
    curl_setopt_array($this->resource, $options);
    $response = curl_exec($this->resource);
    curl_close($this->resource);
    //}
    return new GeoResponse($response);
  }
}
