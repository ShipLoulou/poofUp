<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241208101334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE constructor (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, current_season_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, season_total_point INT NOT NULL, INDEX IDX_7DD91A3912469DE2 (category_id), INDEX IDX_7DD91A3995E6B07D (current_season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pilot (id INT AUTO_INCREMENT NOT NULL, categoty_id INT DEFAULT NULL, current_season_id INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, season_total_point INT NOT NULL, INDEX IDX_8D1E5F529D066842 (categoty_id), INDEX IDX_8D1E5F5295E6B07D (current_season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE constructor ADD CONSTRAINT FK_7DD91A3912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE constructor ADD CONSTRAINT FK_7DD91A3995E6B07D FOREIGN KEY (current_season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE pilot ADD CONSTRAINT FK_8D1E5F529D066842 FOREIGN KEY (categoty_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pilot ADD CONSTRAINT FK_8D1E5F5295E6B07D FOREIGN KEY (current_season_id) REFERENCES season (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constructor DROP FOREIGN KEY FK_7DD91A3912469DE2');
        $this->addSql('ALTER TABLE constructor DROP FOREIGN KEY FK_7DD91A3995E6B07D');
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F529D066842');
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F5295E6B07D');
        $this->addSql('DROP TABLE constructor');
        $this->addSql('DROP TABLE pilot');
    }
}
