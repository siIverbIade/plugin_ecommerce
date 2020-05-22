<?php

$curl = curl_init();
$chave = 'AIzaSyAgjxGGak84swcADckEZIOUEyhBpZPP1Mg';
$endereco = false;
$coordenadas = false;
//$endereco = urlencode('CEP: 23067-100');
$coordenadas = '-23.0199678,-43.4916364';
$params = (!$endereco ? '' : "address=$endereco&") . (!$coordenadas ? '' : "latlng=$coordenadas&");
$options = [
  CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?$params" . "key=$chave"
];

echo "https://maps.googleapis.com/maps/api/geocode/json?$params" . "key=$chave";


curl_setopt_array($curl, $options);

$data = curl_exec($curl);
print_r($data);
curl_close($curl);
