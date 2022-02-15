<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215171438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD poster_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP TABLE movie_has_people');
        $this->addSql('CREATE TABLE movie_has_people (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, significance VARCHAR(255) DEFAULT NULL, People_id INT NOT NULL, Movie_id INT NOT NULL, INDEX IDX_EDC40D81B3B64B95 (People_id), INDEX IDX_EDC40D8176E5D4AA (Movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT FK_EDC40D81B3B64B95 FOREIGN KEY (People_id) REFERENCES people (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT FK_EDC40D8176E5D4AA FOREIGN KEY (Movie_id) REFERENCES movie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movie_has_people');
        $this->addSql('ALTER TABLE movie ADD poster VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, DROP poster_url, CHANGE title title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`');
        $this->addSql('ALTER TABLE people CHANGE firstname firstname VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, CHANGE lastname lastname VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, CHANGE nationality nationality VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`');
        $this->addSql('ALTER TABLE type CHANGE name name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`');
    }
}
