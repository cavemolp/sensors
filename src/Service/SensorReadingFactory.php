<?php

namespace App\Service;

use App\Entity\Sensor;
use App\Entity\SensorReading;
use App\Repository\SensorRepository;
use App\Utils\TemperatureUtils;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class SensorReadingFactory
{
    public function __construct(
        private SensorRepository $sensorRepository
    ) {
    }

    public function createFromRequest(Request $request, bool $isValueInFahrenheits = true): SensorReading
    {
        $request = json_decode($request->getContent(), true);
        $sensorId = $request['reading']['sensor_uuid'];
        $temperature = $request['reading']['temperature'];

        /** @var Sensor $sensor */
        $sensor = $this->sensorRepository->find(Uuid::fromString($sensorId));

        if ($isValueInFahrenheits) {
            $temperature = TemperatureUtils::fahrenheitToCelsius($temperature);
        }

        return new SensorReading(
            sensor: $sensor,
            temperatureCelsius: $temperature
        );
    }

    public function createFromCSV(string $csvString, string $sensorIp, bool $isValueInFahrenheits = false): SensorReading
    {
        $values = explode(',', $csvString);

        // TODO: Reading ID is being ignore, because it's not clear what is the purpose of it
        $temperature = floatval($values[1]);

        /** @var Sensor $sensor */
        $sensor = $this->sensorRepository->findOneBy(['ipAddress' => $sensorIp]);

        if ($isValueInFahrenheits) {
            $temperature = TemperatureUtils::fahrenheitToCelsius($temperature);
        }

        return new SensorReading(
            sensor: $sensor,
            temperatureCelsius: $temperature
        );
    }
}