<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221006224037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sensor (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, reading_number INT NOT NULL, ip_address VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BC8617B022FFD58C ON sensor (ip_address)');
        $this->addSql('COMMENT ON COLUMN sensor.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE sensor_reading (id UUID NOT NULL, sensor_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, temperature_celsius DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DC037B0BA247991F ON sensor_reading (sensor_id)');
        $this->addSql('COMMENT ON COLUMN sensor_reading.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sensor_reading.sensor_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE sensor_reading ADD CONSTRAINT FK_DC037B0BA247991F FOREIGN KEY (sensor_id) REFERENCES sensor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sensor_reading DROP CONSTRAINT FK_DC037B0BA247991F');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE sensor_reading');
    }
}
