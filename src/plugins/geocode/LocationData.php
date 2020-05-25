<?php

namespace App\plugins\geocode;

class LocationData
{
    private string $address = '';
    private string $postalCode = '';
    private float $latitud = 0;
    private float $longitud = 0;

    public function __construct()
    {
    }

    private static function getSingleParameter(string $name, $value = true): string
    {
        $encodedValue = urlencode($value);
        return ($value ? '' : "$name=$encodedValue&");
    }

    public function getParameters(): string
    {
        $parameters = '';
        foreach (get_class_vars(get_class($this)) as $name => $value) {
            $parameters .= self::getSingleParameter($name, $value);
        }
        return $parameters;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function setLatitud(float $latitud)
    {
        $this->latitud = $latitud;
    }

    public function setlongitud(float $longitud)
    {
        $this->longitud = $longitud;
    }
}
