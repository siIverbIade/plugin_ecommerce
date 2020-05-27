<?php

namespace App\plugins\geocode;

class LocationData
{
    private string $address;
    private string $components;
    private string $place_id;
    private string $latlng;

    public function __construct(string $address = '', array $components = [], string $place_id = '', GeoCoordinates $coords = null)
    {
        $this->address =  $address;
        $this->setComponents($components);
        $this->place_id =  $place_id;
        $this->setLatitud($coords->getLatitud());
        $this->setLongitud($coords->getLongitud());
    }

    private static function getSingleParameter(string $name, $value): string
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

    private function getComponent(string $arg): string
    {
        return $this->getComponents()[$arg];
    }

    private function getComponents(): array
    {
        $map = [];
        if (isset($this->components)) {
            foreach (explode('|', $this->components) as $value) {
                $split = explode(':', $value);
                $map[$split[0]] = $split[1];
            }
        }
        return $map;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getRegion()
    {
        return $this->getComponent('region');
    }

    public function getLocality(): string
    {
        return $this->getComponent('locality');
    }

    public function getCountry(): string
    {
        return $this->getComponent('country');
    }

    public function getPostalCode(): string
    {
        return $this->getComponent('postal_code');
    }

    public function getLatitud(): string
    {
        return explode(',', $this->latlng)[0];
    }

    public function getLongitud(): string
    {
        return explode(',', $this->latlng)[1];
    }

    public function getPlaceId()
    {
        return $this->place_id;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    private function setComponents(array $components)
    {
        $map = [];
        foreach ($components as $ind => $val) {
            $map[] = "$ind:$val";
        }
        $this->components = implode('|', $map);
    }

    private function setComponent(string $name, string $value)
    {
        $array = $this->getComponents();
        if (!key_exists($name, $array)) {
            $array[$name] = $value;
        } else {
            if ($value == '') unset($array[$name]);
        }
        $this->setComponents($array);
    }

    public function setRegion(string $region)
    {
        $this->setComponent('region', $region);
    }

    public function setLocality(string $locality)
    {
        $this->setComponent('locality', $locality);
    }

    public function setCountry(string $country)
    {
        $this->setComponent('country', $country);
    }

    public function setPostalCode(string $postalCode)
    {
        $this->setComponent('postal_code', $postalCode);
    }

    public function setLatitud(float $latitud)
    {
        if (isset($this->latlng)) {
            $latlng = explode(',', $this->latlng);
        } else {
            $latlng = [];
        }
        $latlng[0] = $latitud;
        $this->latlng = implode(',', $latlng);
    }

    public function setLongitud(float $longitud)
    {
        if (isset($this->latlng)) {
            $latlng = explode(',', $this->latlng);
        } else {
            $latlng = [];
        }
        $latlng[1] = $longitud;
        $this->latlng = implode(',', $latlng);
    }

    public function setPlaceId(string $id)
    {
        $this->place_id = $id;
    }
}
