<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190307140621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE personal_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE personnal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personnal (id INT NOT NULL, company_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, function VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C2D036DA979B1AD6 ON personnal (company_id)');
        $this->addSql('CREATE TABLE personnal_flight (personnal_id INT NOT NULL, flight_id INT NOT NULL, PRIMARY KEY(personnal_id, flight_id))');
        $this->addSql('CREATE INDEX IDX_B345E0E2E99036B5 ON personnal_flight (personnal_id)');
        $this->addSql('CREATE INDEX IDX_B345E0E291F478C5 ON personnal_flight (flight_id)');
        $this->addSql('ALTER TABLE personnal ADD CONSTRAINT FK_C2D036DA979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personnal_flight ADD CONSTRAINT FK_B345E0E2E99036B5 FOREIGN KEY (personnal_id) REFERENCES personnal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personnal_flight ADD CONSTRAINT FK_B345E0E291F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE personal');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personnal_flight DROP CONSTRAINT FK_B345E0E2E99036B5');
        $this->addSql('DROP SEQUENCE personnal_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE personal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personal (id INT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, function VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_f18a6d84979b1ad6 ON personal (company_id)');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT fk_f18a6d84979b1ad6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE personnal');
        $this->addSql('DROP TABLE personnal_flight');
    }
}
