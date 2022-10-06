<?php

namespace App\Command;

use App\Repository\SensorReadingRepository;
use App\Service\SensorReadingFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'sensors:read:csv',
)]
class ReadSensorCommand extends Command
{
    private const SENSOR_HOST = 'http://sensors-nginx';

    public function __construct(
        private SensorReadingFactory $readingFactory,
        private SensorReadingRepository $readingRepository,
        private HttpClientInterface $client
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('ipAddress',  InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ipAddress = $input->getArgument('ipAddress');
        try {
            $output->writeln("Get sensor {$ipAddress} readings");
            $response = $this->client->request(
                'GET',
                self::SENSOR_HOST.'/sensors/'.$ipAddress.'/data'
            );

            $reading = $this->readingFactory->createFromCSV($response->getContent(), $ipAddress);
            $this->readingRepository->addTemperatureReading($reading);

            $output->writeln('Sensor reading received');
            return Command::SUCCESS;
        } catch (\Exception $error) {
            $output->writeln($error->getMessage());
            return Command::FAILURE;
        }
    }
}