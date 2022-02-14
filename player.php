<?php
class Player
{
    private $name;
    private $city;

    public function __construct($name) {
        $this->name = trim($name);
    }

    public function setCity($city) {
        $this->city = trim($city);
        return $this;
    }

    public function getName():string {
        if (isset($this->name))
            return ucfirst($this->name);
        return "";
    }

    public function getCity():string {
        if (isset($this->city))
            return "(" . ucfirst($this->city) . ")";
        return "";
    }
}
