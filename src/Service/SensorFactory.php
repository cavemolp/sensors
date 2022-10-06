<?php

namespace App\Service;

use App\Entity\Sensor;
use Symfony\Component\HttpFoundation\Request;

class SensorFactory
{
    public function createSensorFromRequest(Request $request): Sensor
    {
        $request = json_decode($request->getContent(), true);
        $ipAddress = $request['ip_address'];

        return new Sensor($ipAddress);
    }
}