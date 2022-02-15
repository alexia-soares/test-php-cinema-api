<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215163219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_has_people (Movie_id INT NOT NULL, People_id INT NOT NULL, INDEX IDX_EDC40D8176E5D4AA (Movie_id), INDEX IDX_EDC40D81B3B64B95 (People_id), PRIMARY KEY(Movie_id, People_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_has_type (Movie_id INT NOT NULL, Type_id INT NOT NULL, INDEX IDX_D7417FB76E5D4AA (Movie_id), INDEX IDX_D7417FBAF1B50F (Type_id), PRIMARY KEY(Movie_id, Type_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE people (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, date_of_birth DATETIME NOT NULL, nationality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT FK_EDC40D8176E5D4AA FOREIGN KEY (Movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE movie_has_people ADD CONSTRAINT FK_EDC40D81B3B64B95 FOREIGN KEY (People_id) REFERENCES people (id)');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FB76E5D4AA FOREIGN KEY (Movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FBAF1B50F FOREIGN KEY (Type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_has_people DROP FOREIGN KEY FK_EDC40D8176E5D4AA');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FB76E5D4AA');
        $this->addSql('ALTER TABLE movie_has_people DROP FOREIGN KEY FK_EDC40D81B3B64B95');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FBAF1B50F');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_has_people');
        $this->addSql('DROP TABLE movie_has_type');
        $this->addSql('DROP TABLE people');
        $this->addSql('DROP TABLE type');
    }
}
