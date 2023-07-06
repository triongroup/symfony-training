<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704133746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, released_at DATE NOT NULL --(DC2Type:date_immutable)
        , isbn VARCHAR(20) NOT NULL, price INTEGER DEFAULT NULL, cover VARCHAR(255) NOT NULL, plot CLOB NOT NULL, editor VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content CLOB NOT NULL, posted_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_9474526C16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9474526C16A2B381 ON comment (book_id)');
        $this->addSql('ALTER TABLE movie ADD COLUMN imdb_id CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD COLUMN rated VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, poster, country, released_at, plot, price FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, poster VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, released_at DATE NOT NULL --(DC2Type:date_immutable)
        , plot CLOB NOT NULL, price INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO movie (id, title, poster, country, released_at, plot, price) SELECT id, title, poster, country, released_at, plot, price FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}
