<?php

namespace App\Utils;

class TemperatureUtils
{
    static public function fahrenheitToCelsius(float $temperature): float
    {
        return ($temperature - 32) * 0.5556;
    }

    static public function celsiusToFahrenheit(float $temperature): float
    {
        return $temperature / 0.5556 + 32;
    }

    static public function readTemperature()
    {
        return round(rand(0, 10000) / 100, 2);
    }
}