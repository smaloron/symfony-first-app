<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217105128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__author AS SELECT id, name, first_name, pwd FROM author');
        $this->addSql('DROP TABLE author');
        $this->addSql('CREATE TABLE author (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, first_name VARCHAR(50) DEFAULT NULL COLLATE BINARY, pwd VARCHAR(128) NOT NULL, email VARCHAR(50) DEFAULT NULL)');
        $this->addSql('INSERT INTO author (id, name, first_name, pwd) SELECT id, name, first_name, pwd FROM __temp__author');
        $this->addSql('DROP TABLE __temp__author');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__author AS SELECT id, name, first_name, pwd FROM author');
        $this->addSql('DROP TABLE author');
        $this->addSql('CREATE TABLE author (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, pwd VARCHAR(50) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO author (id, name, first_name, pwd) SELECT id, name, first_name, pwd FROM __temp__author');
        $this->addSql('DROP TABLE __temp__author');
    }
}
