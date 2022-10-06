<?php

namespace App\Repository;

use App\Entity\SensorReading;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class SensorReadingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SensorReading::class);
    }

    public function getAllSensorAvgTemperature(int $periodDays): float
    {
        $periodStart = Carbon::now()->subDays($periodDays);

        return $this->getAverageTemperatureQueryBuilder($periodStart)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getParticularSensorAvgTemperature(string $sensorId, int $periodHours = 1): float
    {
        $periodStart = Carbon::now()->subHours($periodHours);

        return $this->getAverageTemperatureQueryBuilder($periodStart)
            ->andWhere('readings.sensor = :sensor_id')
            ->setParameter('sensor_id', $sensorId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getAverageTemperatureQueryBuilder(DateTimeInterface $periodStart): QueryBuilder
    {
        return $this->createQueryBuilder('readings')
            ->select('AVG(readings.temperatureCelsius)')
            ->where('readings.createdAt > :period_start')
            ->setParameter('period_start', $periodStart);
    }

    public function addTemperatureReading(SensorReading $reading): void
    {
        $this->getEntityManager()->persist($reading);
        $this->getEntityManager()->flush();
    }
}