<?php

namespace App\Controller;

use App\Repository\SensorReadingRepository;
use App\Service\SensorReadingFactory;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/sensor-readings")]
class SensorReadingController extends AbstractFOSRestController
{
    private const DEFAULT_PERIOD_DAY_AMOUNT = 1;

    #[Route('', name: 'get_average_sensor_readings', methods: ['GET'])]
    public function getAverageSensorData(Request $request, SensorReadingRepository $readingRepository): View
    {
        $periodDays = $request->query->get('period_days', self::DEFAULT_PERIOD_DAY_AMOUNT);

        return $this->view([
            'average_temperature' => $readingRepository->getAllSensorAvgTemperature($periodDays)
        ], Response::HTTP_OK);
    }

    #[Route('/{sensorId}', name: 'get_particular_sensor_readings', methods: ['GET'])]
    public function getSensorData(
        string $sensorId,
        SensorReadingRepository $readingRepository
    ): View {
        return $this->view([
            'average_temperature' => $readingRepository->getParticularSensorAvgTemperature($sensorId)
        ], Response::HTTP_OK);
    }

    #[Route('', name: 'create_sensor_reading', methods: ['POST'])]
    public function createSensorReading(
        Request $request,
        SensorReadingFactory $readingFactory,
        SensorReadingRepository $readingRepository
    ): View {
        $reading = $readingFactory->createFromRequest($request);
        $readingRepository->addTemperatureReading($reading);

        return $this->view(null, Response::HTTP_OK);
    }
}