<?php

namespace App\Controller;

use App\Entity\Sensor;
use App\Repository\SensorReadingRepository;
use App\Repository\SensorRepository;
use App\Service\SensorFactory;
use App\Utils\TemperatureUtils;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/sensors")]
class SensorController extends AbstractFOSRestController
{
    #[Route('', name: 'add_sensor', methods: ['POST'])]
    public function addSensor(Request $request, SensorFactory $sensorFactory, SensorRepository $sensorRepository): View
    {
        $sensor = $sensorFactory->createSensorFromRequest($request);
        $sensorRepository->addSensor($sensor);

        return $this->view(null, Response::HTTP_OK);
    }

    #[Route('/{ipAddress}/data', name: 'read_temperature', methods: ['GET'])]
    public function readData(string $ipAddress, SensorRepository $sensorRepository): View
    {
        $readingId = $sensorRepository->incrementAndReturnReadingNumber($ipAddress);
        $temperature = TemperatureUtils::readTemperature();

        return $this->view(implode(',', [$readingId, $temperature]), Response::HTTP_OK);
    }
}