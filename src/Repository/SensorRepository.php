<?php

namespace App\Repository;

use App\Entity\Sensor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SensorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sensor::class);
    }

    public function addSensor(Sensor $sensor): void
    {
        $this->getEntityManager()->persist($sensor);
        $this->getEntityManager()->flush();
    }

    public function incrementAndReturnReadingNumber(string $ipAddress): int
    {
        /** @var Sensor $sensor */
        $sensor = $this->findOneBy(['ipAddress' => $ipAddress]);
        $sensor->incrementReadingNumber();
        $this->getEntityManager()->flush();

        return $sensor->getReadingNumber();
    }
}