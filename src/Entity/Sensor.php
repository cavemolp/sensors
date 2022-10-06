<?php

namespace App\Entity;

use App\Repository\SensorRepository;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: 'integer')]
    private int $readingNumber;

    public function __construct(
        #[ORM\Column(type: 'string', unique: true)]
        private string $ipAddress,
    ) {
        $this->id = Uuid::uuid4();
        $this->createdAt = Carbon::now();
        $this->readingNumber = 0;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getReadingNumber(): int
    {
        return $this->readingNumber;
    }

    public function incrementReadingNumber(): void
    {
        $this->readingNumber++;
    }
}