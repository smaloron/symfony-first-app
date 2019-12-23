<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191223133114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE book_author (book_id INTEGER NOT NULL, author_id INTEGER NOT NULL, PRIMARY KEY(book_id, author_id))');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, title, price, publisher_id FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(80) NOT NULL COLLATE BINARY, price NUMERIC(5, 2) DEFAULT NULL, publisher_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO book (id, title, price, publisher_id) SELECT id, title, price, publisher_id FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE book_author');
        $this->addSql('ALTER TABLE book ADD COLUMN author VARCHAR(50) NOT NULL COLLATE BINARY');
    }
}
