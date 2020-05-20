<?php

$json = '{
    "considerIp": "true",
    "wifiAccessPoints": [
      {
          "macAddress": "AC:84:C6:0D:2C:9D",
          "signalStrength": -43,
          "signalToNoiseRatio": 0
      }
    ]
  }';
//print_r(json_decode($json));

$curl = curl_init();
$chave = 'AIzaSyAgjxGGak84swcADckEZIOUEyhBpZPP1Mg';
$options = [
    CURLOPT_URL => "https://www.googleapis.com/geolocation/v1/geolocate?key=$chave",
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
];

curl_setopt_array($curl, $options);

$data = curl_exec($curl);
print_r($data);
curl_close($curl);
