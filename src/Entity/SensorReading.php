<?php

namespace App\Entity;

use App\Repository\SensorReadingRepository;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: SensorReadingRepository::class)]
class SensorReading {
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Sensor::class)]
        private Sensor $sensor,

        #[ORM\Column(type: 'float')]
        private float $temperatureCelsius,

        ?UuidInterface $id = null,
    ) {
        $this->id = $id ?? Uuid::uuid4();
        $this->createdAt = Carbon::now();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getSensor(): Sensor
    {
        return $this->sensor;
    }

    public function getTemperature(): float
    {
        return $this->temperatureCelsius;
    }
}