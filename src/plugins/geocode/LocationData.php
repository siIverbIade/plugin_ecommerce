<?php

namespace App\plugins\geocode;

class LocationData
{
    private string $address;
    private string $location;
    private string $postal_code;
    private float $latitud;
    private float $longitud;

    public function __construct()
    {
    }

    public static function getSingleParameter(string $name, $value): string
    {
        $encodedValue = urlencode($value);
        return (($value == null) ? '' : "$name=$encodedValue&");
    }

    public function getParameters(): string
    {
        $parameters = '';
        foreach (get_class_vars(get_class($this)) as $name => $val) {
            $value = isset($this->{$name}) ? $this->{$name} : '';
            $parameters .= self::getSingleParameter($name, $value);
        }
        return $parameters;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getPostalCode(): string
    {
        return $this->postal_code;
    }

    public function getLatitud(): string
    {
        return $this->latitud;
    }

    public function getLongitud(): string
    {
        return $this->longitud;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    public function setPostalCode(string $postalCode)
    {
        $this->postal_code = $postalCode;
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
